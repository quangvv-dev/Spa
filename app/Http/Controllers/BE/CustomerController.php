<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
use App\Models\Customer;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Status;
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
        $statuses = Status::getRelationship();
        $title = 'Danh sách khách hàng';
        $customers = Customer::search($request->all());

        if ($request->ajax()) {
            return Response::json(view('customers.ajax', compact('customers', 'statuses', 'title'))->render());
        }

        return view('customers.index', compact('customers', 'statuses', 'title'));
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
        $input = $request->all();
        $input['mkt_id'] = $request->mkt_id;

        $this->customerService->create($input);

        return redirect('customers')->with('status', 'Tạo người dùng thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Trao đổi';
        $customer = Customer::with('status', 'marketing', 'category', 'telesale', 'source_customer', 'orders')->findOrFail($id);
        $docs = Model::orderBy('id', 'desc')->get();
        return view('customers.view_account', compact('title', 'docs', 'customer'));
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
        $title = 'Sửa khách hàng';
        return view('customers._form', compact('customer', 'title'));
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
        $input = $request->all();

        $this->customerService->update($input, $id);

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
//                dd(Auth::user());
                foreach ($result as $k => $row) {
                    Customer::create([
                        'full_name'    => $row['ten_khach_hang'],
                        'account_code' => $row['ma_khach_hang'],
                        'mkt_id'       => @Auth::user()->id,
                        'phone'        => $row['so_dien_thoai'],
                        'birthday'     => $row['sinh_nhat'],
                        'gender'       => $row['gioi_tinh'] == 'Nữ' ? 0 : 1,
                        'address'      => $row['dia_chi'] ?: '',
                        'facebook'     => $row['link_facebook'] ?: '',
                        'description'  => $row['mo_ta'],
                    ]);
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
        $input = $request->all();
        $customer = $this->customerService->find($id);
        $customer->update($input);

        return $customer;
    }

    public function reportCustomer(Request $request)
    {
        $title = 'THỐNG KÊ KHÁCH HÀNG';
        $input = $request->all();

        $customer = Customer::getDataOfYears($input);
        $statusRevenues = Status::getRevenueSource($input);
        $statusRevenueByRelations = Status::getRevenueSourceByRelation($input);

        $statuses = Status::getRelationship($input);

        $categoryRevenues = Category::getRevenue($input);
        $customerRevenueByGenders = Customer::getRevenueByGender($input);

        $orders = Order::getAll($input);
        $groupComments = GroupComment::getAll($input);
        $books = Schedule::getBooks($input);
        $orderTotal = Order::getAll($input)->sum('gross_revenue');

        if ($request->ajax()) {
            return Response::json(view('customers.ajax_chart', compact(
                    'title',
                    'statuses',
                    'customer',
                    'orders',
                    'orderTotal',
                    'statusRevenues',
                    'statusRevenueByRelations',
                    'categoryRevenues',
                    'customerRevenueByGenders',
                    'groupComments',
                    'books'
                ))->render());
        }


        return view('customers.chart', compact(
                'title',
                'statuses',
                'customer',
                'orders',
                'orderTotal',
                'statusRevenues',
                'statusRevenueByRelations',
                'categoryRevenues',
                'customerRevenueByGenders',
                'groupComments',
                'books'
            )
        );
    }
}
