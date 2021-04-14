<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\OrderConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\CustomerPost;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Department;
use App\Models\Genitive;
use App\Models\GroupComment;
use App\Models\HistorySms;

//use App\Models\Order;
//use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\PackageWallet;
use App\Models\Schedule;
use App\Models\Services;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\WalletHistory;
use App\Services\CustomerService;
//use App\Services\OrderService;
use App\Models\RuleOutput;
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
        $this->middleware('permission:customers.list', ['only' => ['index']]);
        $this->middleware('permission:customers.edit', ['only' => ['edit']]);
        $this->middleware('permission:customers.add', ['only' => ['create']]);
        $this->middleware('permission:customers.delete', ['only' => ['destroy']]);

        $this->customerService = $customerService;
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray();//mối quan hệ
        $group = Category::pluck('name', 'id')->toArray();//nhóm KH
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $branch = Status::where('type', StatusCode::BRANCH)->pluck('name', 'id')->toArray();// chi nhánh
        $marketingUsers = User::whereIn('role', [UserConstant::MARKETING, UserConstant::TP_MKT])->pluck('full_name', 'id')->toArray();
        $genitives = Genitive::pluck('name', 'id')->toArray();
        $telesales = [];
        User::get()->map(function ($item) use (&$telesales) {
            if ($item->role == UserConstant::WAITER) {
                $telesales['Lễ Tân'][$item->full_name] = $item->id;
            } elseif ($item->role == UserConstant::TELESALES || $item->role == UserConstant::TP_SALE) {
                $telesales['Telesales'][$item->full_name] = $item->id;
            } elseif ($item->role == UserConstant::CSKH) {
                $telesales['Tư vấn viên'][$item->full_name] = $item->id;
            }
            return $item;
        });
        $the_rest = [
            OrderConstant::THE_REST => 'Còn nợ',
            OrderConstant::NONE_REST => 'Đã thanh toán',
        ];
        view()->share([
            'the_rest'      => $the_rest,
            'status'        => $status,
            'group'         => $group,
            'source'        => $source,
            'branch'        => $branch,
            'telesales'     => $telesales,
            'marketingUsers'=> $marketingUsers,
            'genitives'     => $genitives,
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
        $checkRole = checkRoleAlready();
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        }
        $branchs = Branch::search()->pluck('name', 'id');
        $input = $request->all();
        $customers = Customer::search($input);
        if (isset($input['limit'])) {
            $customers = $customers->latest()->paginate($input['limit']);
        } else {
            $customers = $customers->paginate(StatusCode::PAGINATE_20);
        }
        $statuses = Status::getRelationshipByCustomer($input);
        $categories = Category::where('type', StatusCode::SERVICE)->with('customers')->get();
        $rank = $customers->firstItem();
        if ($request->ajax()) {
            return Response::json(view('customers.ajax', compact('customers', 'statuses', 'rank'))->render());
        }

        return view('customers.index', compact('customers', 'statuses', 'rank', 'categories', 'branchs'));
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

    public function createGroup()
    {
        $title = 'Thêm mới khách hàng';
        $user_sale = User::where('role', UserConstant::TELESALES);
        $sale = $user_sale->pluck('id')->toArray();
        $name = $user_sale->pluck('full_name')->toArray();
        $sale_name = '';
        if (count($name)) {
            foreach ($name as $item) {
                $sale_name .= "'" . $item . "',";
            }
        }
        $sale_name = substr($sale_name, 0, -1);

        return view('customers._form_auto', compact('title', 'sale', 'sale_name'));
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
        $request->merge([
            'fb_name' => $request->full_name,
            'full_name' => str_replace("'", "", $request->full_name),
        ]);
        $input = $request->except(['group_id', 'image']);
        $input['mkt_id'] = $request->mkt_id;
        $input['image'] = $request->image;
        if ((int)$input['status_id'] == StatusCode::ALL) {
            $input['status_id'] = StatusCode::NEW;
        }
        if (Auth::user()->role == UserConstant::WAITER) {
            $request->merge(['telesales_id' => Auth::user()->id]);
        }
        $customer = $this->customerService->create($input);
        $update = $this->update_code($customer);
        $category = Category::find($request->group_id);
        $customer->categories()->attach($category);

        return redirect('customers/' . $customer->id)->with('status', 'Tạo người dùng thành công');
    }

    public function storeGroup(Request $request)
    {
        foreach ($request->full_name as $k => $item) {
            $input['full_name'] = str_replace("'", "", $item);
            $input['phone'] = $request->phone[$k];
            $input['gender'] = $request->gender[$k];
            $input['facebook'] = $request->facebook[$k];
            $input['source_id'] = $request->source_id[$k];
            $input['telesales_id'] = $request->telesales_id[$k];
            $input['fb_name'] = $item;
            $input['mkt_id'] = null;
            $input['status_id'] = StatusCode::NEW;
            $customer = $this->customerService->create($input);
            $update = $this->update_code($customer);
            $category = Category::find($request->group_id[$k]);
            $customer->categories()->attach($category);
        }
        return redirect('customers')->with('status', 'Tạo người dùng thành công');
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
        $customer = Customer::with('status', 'marketing', 'categories', 'telesale', 'source_customer')->findOrFail($id);
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
        //History SMS
        $history = [];
        $customer_post = [];
        $wallet = [];
        $package = [];
        $orders = [];
        if ($request->history_sms) {
            $history = HistorySms::where('phone', $request->history_sms)->orderByDesc('id')->paginate(StatusCode::PAGINATE_20);
            return Response::json(view('sms.history',
                compact('history'))->render());
        }
        if ($request->post) {
            $customer_post = CustomerPost::where('phone', $request->post)->where('status', '<>', 0)->orderByDesc('id')->paginate(StatusCode::PAGINATE_20);
            return Response::json(view('post.history',
                compact('customer_post'))->render());
        }
        if ($request->history_wallet) {
            $wallet = WalletHistory::where('customer_id', $request->history_wallet)->orderByDesc('id')->paginate(StatusCode::PAGINATE_20);
            $package = PackageWallet::pluck('name', 'id')->toArray();
            return Response::json(view('wallet.history', compact('wallet', 'package'))->render());
        }
        if ($request->schedules) {
            return Response::json(view('schedules.index', compact('schedules', 'id', 'staff'))->render());
        }

        if ($request->member_id || $request->role_type || $request->the_rest || $request->page_order) {
            if (!empty($request->page_order)) $request->merge(['page' => $request->page_order]);
            $params = $request->only('member_id', 'role_type', 'the_rest', 'page');
            $orders = Order::search($params);
            return Response::json(view('customers.order', compact('orders', 'waiters'))->render());
        }
        //END

        return view('customers.view_account',
            compact('title', 'docs', 'customer', 'waiters', 'schedules', 'id', 'staff', 'tasks', 'taskStatus', 'customer_post',
                'type', 'users', 'customers', 'priority', 'status', 'progress', 'departments', 'history', 'wallet', 'package', 'orders'));
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->merge(['full_name' => str_replace("'", "", $request->full_name)]);
        $input = $request->except('group_id');
        if ((int)$input['status_id'] == StatusCode::ALL) {
            $input['status_id'] = StatusCode::NEW;
        }
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
        $customer = Customer::where('phone', $request->phone)->withTrashed()->first();

        if ($customer) {
            return $customer->id == $request->id ? 'true' : 'false';
        }

        return 'true';
    }

    public function exportCustomer(Request $request)
    {
        $now = Carbon::now()->format('d/m/Y');
        $data = Customer::orderBy('id', 'desc')->with('orders', 'categories');
        $data = $data->when(!empty($request->group), function ($query) use ($request) {
            $arr = CustomerGroup::where('category_id', $request->group)->pluck('customer_id')->toArray();
            $query->whereIn('id', $arr);
        })->when(!empty($request->status), function ($query) use ($request) {
            $query->where('status_id', $request->status);
        })->get();

        Excel::create('Khách hàng (' . $now . ')', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:Q1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->freezeFirstRow();
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
                        $categoryName = '';
                        $i++;
                        foreach ($ex->categories as $category) {
                            $categoryName .= $category->name . ', ';
                        }
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
                            @$categoryName,
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
                    if (!empty($row['so_dien_thoai'])) {
                        $date = Carbon::createFromFormat('d/m/Y', trim($row['ngay_tao_kh']))->format('Y-m-d');
                        $status = Status::where('name', 'like', '%' . $row['moi_quan_he'] . '%')->first();
                        $telesale = User::where('full_name', 'like', '%' . $row['nguoi_phu_trach'] . '%')->first();
                        $source = Status::where('code', 'like', '%' . str_slug($row['nguon_kh']) . '%')->first();
                        $check = Customer::where('phone', $row['so_dien_thoai'])->withTrashed()->first();
                        $category = explode(',', $row['nhom_khach_hang']);
                        if (empty($check)) {
                            if ($row['so_dien_thoai']) {
                                $data = Customer::create([
                                    'full_name' => $row['ten_khach_hang'],
                                    'account_code' => !empty($row['ma_khach_hang']) ? $row['ma_khach_hang'] : '',
                                    'mkt_id' => @Auth::user()->id,
                                    'telesales_id' => isset($telesale) ? $telesale->id : 1,
                                    'status_id' => isset($status) ? $status->id : 1,
                                    'source_id' => isset($source) ? $source->id : 18,
                                    'phone' => $row['so_dien_thoai'],
                                    'birthday' => $row['sinh_nhat'],
                                    'gender' => str_slug($row['gioi_tinh']) == 'nu' ? 0 : 1,
                                    'address' => $row['dia_chi'] ?: '',
                                    'facebook' => $row['link_facebook'] ?: '',
                                    'description' => $row['mo_ta'],
                                    'created_at' => isset($date) && $date ? $date . ' 00:00:00' : Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at' => isset($date) && $date ? $date . ' 00:00:00' : Carbon::now()->format('Y-m-d H:i:s'),
                                ]);
                                if (count($category)) {
                                    foreach ($category as $item) {
                                        $field = Category::where('name', 'like',
                                            '%' . $item . '%')->first();
                                        if (isset($field) && $field) {
                                            CustomerGroup::create([
                                                'customer_id' => $data->id,
                                                'category_id' => isset($field) ? $field->id : 0,
                                            ]);
                                        }
                                    }
                                } else {
                                    CustomerGroup::create([
                                        'customer_id' => $data->id,
                                        'category_id' => 0,
                                    ]);
                                }
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

        if (isset($customer->birthday)) {
            $customer->birthday = Functions::dayMonthYear($customer->birthday);
        }

        return $customer;
    }

    public function ajaxUpdate(Request $request, $id)
    {
        $input = $request->except('category_ids');
        $before = $this->customerService->find($id);
        $category = CustomerGroup::where('customer_id', $before->id)->pluck('category_id')->toArray();
        $customer = $this->customerService->update($input, $id);
        $check2 = RuleOutput::where('event', 'change_relation')->first();

        if ($customer->status_id != $before->status_id && isset($check2) && $check2) {
            $rule = $check2->rules;
            $config = @json_decode(json_decode($rule->configs))->nodeDataArray;
            $rule_status = Functions::checkRuleStatusCustomer($config);
            foreach (array_values($rule_status) as $k1 => $item) {
                $list_status = $item->configs->group1;
                $list_relation = $item->configs->group;
                $relation = array_intersect($category, $list_relation);
                if (in_array($customer->status_id, $list_status) && count($relation)) {
                    $sms_ws = Functions::checkRuleSms($config);
                    if (count($sms_ws)) {
                        foreach (@array_values($sms_ws) as $k2 => $sms) {
                            $input_raw['full_name'] = @$customer->full_name;
                            $exactly_value = Functions::getExactlyTime($sms);
                            $text = $sms->configs->content;
                            $phone = Functions::convertPhone(@$customer->phone);
                            $text = Functions::replaceTextForUser($input_raw, $text);
                            $text = Functions::vi_to_en($text);
                            $err = Functions::sendSmsV3($phone, @$text, $exactly_value);
                            if (isset($err) && $err) {
                                HistorySms::insert([
                                    'phone' => @$customer->phone,
                                    'campaign_id' => 0,
                                    'message' => $text,
                                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                                    'updated_at' => Carbon::parse($exactly_value)->format('Y-m-d H:i'),
                                ]);
                            }
                        }
                    }
                }
            }
        }
        if (isset($request->category_ids) && $request->category_ids) {
            $customer->categories()->sync($request->category_ids);
        }

        $data = Customer::with('status', 'categories', 'telesale', 'genitive')->where('id', $id)->first();
        if (isset($data->birthday)) {
            $data->birthday = Functions::dayMonthYear($data->birthday);
        }

        return $data;
    }

    public function reportCustomer(Request $request)
    {
        $title = 'THỐNG KÊ KHÁCH HÀNG';
        $input = $request->all();

        $input['data_time'] = $request->data_time ?: 'TODAY';

        $type = $request->type ?: StatusCode::PRODUCT;
        $arr = Services::getIdServiceType($type);
        $input['list_booking'] = $arr;
        $countCustomer = Customer::count($input);
        $statusRevenues = Status::getRevenueSource($input);
        $customerRevenueByGenders = Customer::getRevenueByGender($input);
        $groupComments = GroupComment::getAll($input);
        $input['status_schedule'] = StatusCode::BOOK;
        $books = Schedule::getBooks($input);
        $services = Services::handleChart($arr, $input);
        $service1 = $services->orderBy('count_order', 'desc')->paginate(10);
        $orders = [
            'sum' => $services->get()->sum('count_order'),
            'count' => $services->get()->sum('count'),
        ];

        if ($request->ajax()) {
            return Response::json(view('customers.ajax_chart', compact(
                'title',
                'service1',
                'type',
                'services',
                'orders',
                'statusRevenues',
                'customerRevenueByGenders',
                'groupComments',
                'books',
                'countCustomer'
            ))->render());
        }


        return view('customers.chart', compact(
                'title',
                'type',
                'service1',
                'orders',
                'statusRevenues',
                'customerRevenueByGenders',
                'groupComments',
                'books',
                'countCustomer'
            )
        );
    }

    /**
     * Khôi phục data
     *
     * @param Request $request
     */
    public function restore(Request $request)
    {
        $ids = $request->ids;
        Customer::onlyTrashed()->whereIn('id', $ids)->restore();
    }

    public function updateBranch(Request $request)
    {
        $ids = $request->ids;
        Customer::whereIn('id', $ids)->update(['branch_id' => $request->branch_id]);

    }

    /**
     * Xoá hẳn
     *
     * @param Request $request
     */
    public function forceDelete(Request $request)
    {
        $ids = $request->ids;
        Customer::onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }

    /**
     * Update code
     *
     * @param $customer
     * @return mixed
     */
    public function update_code($customer)
    {
        $customer_id = $customer->id < 10 ? '0' . $customer->id : $customer->id;
        $code = 'KH' . $customer_id;
        $customer->update(['account_code' => $code]);
        return $customer;
    }

    /**
     * Update trạng thái khách hàng
     *
     * @param Request $request
     */
    public function updateMultipleStatus(Request $request)
    {
        $customer = Customer::whereIn('id', $request->ids);

        if (isset($request->status_id)) {
            $customer->update([
                'status_id' => $request->status_id,
            ]);
        }

        if (isset($request->telesales_id)) {
            $customer->update([
                'telesales_id' => (int)$request->telesales_id,
            ]);
        }
    }

    public function getListAjax(Request $request)
    {
        $id = $request->id;

        $customer = Customer::with('telesale')->where('id', $id)->first();

        $telesales = User::whereIn('role', [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->get();

        return [
            'customer' => $customer,
            'data' => $telesales,
        ];
    }
}
