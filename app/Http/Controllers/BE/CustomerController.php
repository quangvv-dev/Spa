<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Department;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\CustomerService;
use App\Services\OrderService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\GroupComment as Model;
use Excel;

class CustomerController extends Controller
{
    private $customerService;

    /**
     * UserController constructor.
     *
     * @param Filesystem $fileUpload
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray();//mối quan hệ
        $group = Category::pluck('name', 'id')->toArray();//nhóm KH
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $branch = Status::where('type', StatusCode::BRANCH)->pluck('name', 'id')->toArray();// chi nhánh
        $marketingUsers = User::where('role', UserConstant::MARKETING)->pluck('full_name', 'id')->toArray();
        $telesales = User::where('role', UserConstant::TELESALES)->pluck('full_name', 'id')->toArray();
        view()->share([
            'status'         => $status,
            'group'          => $group,
            'source'         => $source,
            'branch'         => $branch,
            'telesales'      => $telesales,
            'marketingUsers' => $marketingUsers,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $statuses = Status::getRelationshipByCustomer($request->all());
        $customers = Customer::search($request->all());
        $rank = $customers->firstItem();
        if ($request->ajax()) {

            return Response::json(view('customers.ajax',
                compact('customers', 'statuses', 'rank'))->render());
        }

        return view('customers.index', compact('customers', 'statuses', 'rank'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm mới khách hàng';
        return view('customers._form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['group_id', 'image']);
        $input['mkt_id'] = $request->mkt_id;
        $input['image'] = $request->image;

        $customer = $this->customerService->create($input);
        $update = $this->update_code($customer);
        $category = Category::find($request->group_id);
        $customer->categories()->attach($category);

        return redirect('customers/' . $customer->id)->with('status', 'Tạo người dùng thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $title = 'Trao đổi';
        $customer = Customer::with('status', 'marketing', 'category', 'telesale', 'source_customer',
            'orders')->findOrFail($id);
        $waiters = User::where('role', UserConstant::TECHNICIANS)->pluck('full_name', 'id');
        $staff = User::where('role', '<>', UserConstant::ADMIN)->get()->pluck('full_name', 'id')->toArray();
        $schedules = Schedule::orderBy('id', 'desc')->where('user_id', $id)->paginate(10);
        $docs = Model::where('customer_id', $id)->orderBy('id', 'desc')->get();

        //Task
        $input['type'] = $request->type ?: 'qf1';
        $type = Task::TYPE;
        $users = User::pluck('full_name', 'id');
        $customers = Customer::find($id);
        $customers = [
            $customers->id => $customers->full_name,
        ];
        $priority = Task::PRIORITY;
        $tasks = Task::where('customer_id', $id)->orderBy('id', 'DESC')->get();
        $taskStatus = TaskStatus::with('tasks')->get();
        $status = TaskStatus::pluck('name', 'id')->toArray();
        $progress = Task::PROGRESS;
        $departments = Department::pluck('name', 'id');

        //EndTask

        return view('customers.view_account',
            compact('title', 'docs', 'customer', 'waiters', 'schedules', 'id', 'staff', 'tasks', 'taskStatus',
                'type', 'users', 'customers', 'priority', 'status', 'progress', 'departments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $user['birthday'] = Functions::dayMonthYear($customer->birthday);
        $categories = Category::get();
        $categoryId = $customer->categories()->get()->pluck('id')->toArray();
        $title = 'Sửa khách hàng';
        return view('customers._form', compact('customer', 'title', 'categories', 'categoryId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('group_id');

        $customer = $this->customerService->update($input, $id);
        $customer->categories()->sync($request->group_id);

        return redirect(route('customers.index'))->with('status', 'Cập nhật khách hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Customer $customer)
    {
        $customer->delete();
        $request->session()->flash('error', 'Xóa người dùng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param array $id
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        Customer::whereIn('id', $ids)->delete();

        $request->session()->flash('error', 'Xóa dữ liệu thành công!');
    }

    public function checkUniquePhone(Request $request)
    {
        $customer = Customer::where('phone', $request->phone)->first();

        if ($customer) {
            return $customer->id == $request->id ? 'true' : 'false';
        }

        return 'true';
    }

    public function exportCustomer()
    {
        $now = Carbon::now()->format('d/m/Y');
        $data = Customer::orderBy('id', 'desc')->with('orders');
        //        $rq = $request->all();
//        if ($rq['search']) {
//            $data = $data->where('name', 'like', '%' . $rq['search'] . '%')
//                ->orWhere('email', 'like', '%' . $rq['search'] . '%')
//                ->orWhere('phone', 'like', '%' . $rq['search'] . '%');
//        }
        $data = $data->get();
        Excel::create('Khách hàng (' . $now . ')', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:Q1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->row(1, [
                    'ID',
                    'Tên khách hàng',
                    'Mã khách hàng',
                    'Số điện thoại',
                    'Sinh nhật',
                    'Giới tính',
                    'Link Facebook',
                    'Địa chỉ',
                    'Ngày tạo',
                    'Số đơn',
                    'Tổng doanh thu',
                    'ID người phụ trách',
                    'ID người tư vấn',
                    'ID nhóm KH',
                    'ID nguồn KH',
                    'ID Mối quan hệ',
                    'Mô tả',
                ]);
                $i = 1;
                if ($data) {
                    foreach ($data as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$ex->id,
                            @$ex->full_name,
                            @$ex->account_code,
                            @$ex->phone,
                            @$ex->birthday,
                            @$ex->GenderText,
                            @$ex->facebook,
                            @$ex->address,
                            @$ex->created_at,
                            @$ex->orders->count(),
                            @(int)$ex->orders->sum('all_total'),
                            @$ex->marketing->full_name,
                            @$ex->telesale->full_name,
                            @$ex->category->name,
                            @$ex->source_customer->name,
                            @$ex->status->name,
                            @$ex->description,
                            // (@$ex->type == 0) ? 'Tài khoản thường' : 'Tài khoản VIP',
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }

    public function importCustomer(Request $request)
    {
        if ($request->hasFile('file')) {
            Excel::load($request->file('file')->getRealPath(), function ($render) {
                $result = $render->toArray();
                foreach ($result as $k => $row) {
                    $date = Carbon::createFromFormat('d/m/Y H:i:s', $row['ngay_tao_kh'])->format('Y-m-d H:i:s');
                    $status = Status::where('name', 'like', '%' . $row['moi_quan_he'] . '%')->first();
                    $telesale = User::where('full_name', 'like', '%' . $row['nguoi_phu_trach'] . '%')->first();
                    $source = Status::where('code', 'like', '%' . str_slug($row['nguon_kh']) . '%')->first();
                    $check = Customer::where('phone', $row['so_dien_thoai'])->first();
                    $category = explode(',', $row['nhom_khach_hang']);
                    if (empty($check)) {
                        if ($row['so_dien_thoai']) {
                            $data = Customer::create([
                                'full_name'    => $row['ten_khach_hang'],
                                'account_code' => $row['ma_khach_hang'],
                                'mkt_id'       => @Auth::user()->id,
                                'telesales_id' => isset($telesale) ? $telesale->id : 1,
                                'status_id'    => isset($status) ? $status->id : 1,
                                'source_id'    => isset($source) ? $source->id : 18,
                                'phone'        => $row['so_dien_thoai'],
                                'birthday'     => $row['sinh_nhat'],
                                'gender'       => str_slug($row['gioi_tinh']) == 'nu' ? 0 : 1,
                                'address'      => $row['dia_chi'] ?: '',
                                'facebook'     => $row['link_facebook'] ?: '',
                                'description'  => $row['mo_ta'],
                                'created_at'   => isset($date) && $date ? $date : Carbon::now()->format('Y-m-d H:i:s'),
                                'updated_at'   => isset($date) && $date ? $date : Carbon::now()->format('Y-m-d H:i:s'),
                            ]);

                            if (count($category)) {
                                foreach ($category as $item) {
                                    $field = Category::where('name', 'like',
                                        '%' . $item . '%')->first();
                                }
                                CustomerGroup::create([
                                    'customer_id' => $data->id,
                                    'category_id' => isset($field) ? $field->id : 25,
                                ]);
                            } else {
                                CustomerGroup::create([
                                    'customer_id' => $data->id,
                                    'category_id' => 25,
                                ]);
                            }
                        }
                    }
                }
            });
            return redirect()->back()->with('status', 'Tải khách hàng thành công');
        }
    }

    public function getCustomerById($id)
    {
        $customer = $this->customerService->find($id);

        return $customer;
    }

    public function ajaxUpdate(Request $request, $id)
    {
        $input = $request->except('category_ids');
        $customer = $this->customerService->update($input, $id);
        if (isset($request->category_ids) && $request->category_ids) {
            $customer->categories()->sync($request->category_ids);
        }

        $data = Customer::with('status', 'categories', 'telesale')->where('id', $id)->first();

        return $data;
    }

    public function reportCustomer(Request $request)
    {
        $title = 'THỐNG KÊ KHÁCH HÀNG';
        $input = $request->all();

        $input['order_id'] = null;
        $input['data_time'] = $request->data_time ?: 'THIS_MONTH';

        $customer = Customer::getDataOfYears($input);
        $countCustomer = Customer::count($input);
        $statusRevenues = Status::getRevenueSource($input);
        $statuses = Status::getRelationship($input);
        $statusRevenueByRelations = Status::getRevenueSourceByRelation($input);

        $categoryRevenues = Category::getRevenue($input);
        $customerRevenueByGenders = Customer::getRevenueByGender($input);

        $orders = Order::getAll($input);
        $groupComments = GroupComment::getAll($input);
        $books = Schedule::getBooks($input);
        $schedules = Schedule::countStatus($input);

        if ($request->ajax()) {
            return Response::json(view('customers.ajax_chart', compact(
                'title',
                'statuses',
                'customer',
                'orders',
                'statusRevenues',
                'statusRevenueByRelations',
                'categoryRevenues',
                'customerRevenueByGenders',
                'groupComments',
                'books',
                'countCustomer',
                'schedules'
            ))->render());
        }


        return view('customers.chart', compact(
                'title',
                'statuses',
                'customer',
                'orders',
                'statusRevenues',
                'statusRevenueByRelations',
                'categoryRevenues',
                'customerRevenueByGenders',
                'groupComments',
                'books',
                'countCustomer',
                'schedules'
            )
        );
    }

    public function restore(Request $request)
    {
        $ids = $request->ids;
        Customer::onlyTrashed()->whereIn('id', $ids)->restore();
    }

    public function forceDelete(Request $request)
    {
        $ids = $request->ids;
        Customer::onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }

    /**
     * update code
     *
     * @param $customer
     */
    public function update_code($customer)
    {
        $customer_id = $customer->id < 10 ? '0' . $customer->id : $customer->id;
        $code = 'KH' . $customer_id;
        $customer->update(['account_code' => $code]);
        return $customer;
    }

    public function updateMultipleStatus(Request $request)
    {
        $customer = Customer::whereIn('id', $request->ids)->update(['status_id' => $request->status_id]);
    }

    public function getListAjax(Request $request)
    {
        $id = $request->id;

        $customer = Customer::with('telesale')->where('id', $id)->first();

        $telesales = User::where('role', UserConstant::TELESALES)->get();

        return [
            'customer' => $customer,
            'data' => $telesales
        ];
    }
}
