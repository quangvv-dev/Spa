<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\DepartmentConstant;
use App\Constants\NotificationConstant;
use App\Constants\OrderConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Constants\UserConstant;
use App\CustomerPost;
use App\Helpers\Functions;
use App\Models\Album;
use App\Models\Branch;
use App\Models\CallCenter;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Department;
use App\Models\Genitive;
use App\Models\GroupComment;
use App\Models\HistorySms;

use App\Models\Notification;
use App\Models\Order;
use App\Models\PackageWallet;
use App\Models\Schedule;
use App\Models\SchedulesSms;
use App\Models\Services;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Tip;
use App\Models\UserFilterGrid;
use App\Models\WalletHistory;
use App\Services\CustomerService;
use App\Models\RuleOutput;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\GroupComment as Model;

use App\Services\TaskService;

use Excel;
use function PHPSTORM_META\type;

class CustomerController extends Controller
{
    private $customerService;
    private $taskService;


    /**
     * UserController constructor.
     *
     * @param Filesystem $fileUpload
     */
    public function __construct(CustomerService $customerService, TaskService $taskService)
    {
        $this->middleware('permission:customers.list', ['only' => ['index']]);
        $this->middleware('permission:customers.edit', ['only' => ['edit']]);
        $this->middleware('permission:customers.add', ['only' => ['create']]);
        $this->middleware('permission:customers.delete', ['only' => ['destroy']]);

        $this->taskService = $taskService;
        $this->customerService = $customerService;

        $status = Status::where('type', StatusCode::RELATIONSHIP)->select('name', 'id')->pluck('name',
            'id')->toArray();//mối quan hệ
        $group = Category::pluck('name', 'id')->toArray();//nhóm KH
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->select('name', 'id')->pluck('name',
            'id')->toArray();// nguồn KH
        $branchs = Branch::search()->pluck('name', 'id');// chi nhánh
        $marketingUsers = User::whereIn('department_id', [DepartmentConstant::MARKETING])->select('full_name',
            'id')->pluck('full_name', 'id')->toArray();
        $genitives = Genitive::select('id', 'name')->pluck('name', 'id')->toArray();
        $telesales = [];
        User::select('id', 'department_id', 'full_name')->get()->map(function ($item) use (&$telesales) {
            if ($item->department_id == DepartmentConstant::WAITER) {
                $telesales['Lễ Tân'][$item->full_name] = $item->id;
            } elseif ($item->department_id == DepartmentConstant::TELESALES) {
                $telesales['Telesales'][$item->full_name] = $item->id;
            } elseif ($item->department_id == UserConstant::TECHNICIANS) {
                $telesales['Tư vấn viên'][$item->full_name] = $item->id;
            }
            return $item;
        });
        $the_rest = [
            OrderConstant::THE_REST => 'Còn nợ',
            OrderConstant::NONE_REST => 'Đã thanh toán',
        ];
        $location = Branch::$location;
        view()->share([
            'the_rest' => $the_rest,
            'status' => $status,
            'group' => $group,
            'source' => $source,
            'branchs' => $branchs,
            'telesales' => $telesales,
            'marketingUsers' => $marketingUsers,
            'genitives' => $genitives,
            'location' => $location,
        ]);
    }

    /**.
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $checkRole = checkRoleAlready();
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        } elseif (count($input) < 1) {
            $input['branch_id'] = 1;
        }
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        if (isset($input['search']) && $input['search'] && is_numeric($input['search'])) {
            unset($input['branch_id']);
        }
        $carePageUsers = User::whereIn('department_id', [DepartmentConstant::CARE_PAGE])->select('full_name', 'id')->pluck('full_name', 'id')->toArray();
        $statuses = Status::getRelationshipByCustomer($input);
        $page = $request->page;
        $customers = Customer::search($input);
        $birthday = clone $customers;
        $birthday = $birthday->whereRaw('DATE_FORMAT(birthday, "%m-%d") = ?', Carbon::now()->format('m-d'))->count();

        $customers = $customers->take(StatusCode::PAGINATE_1000)->orderByDesc('id')->get();
        if (isset($input['limit'])) {
            $customers = Functions::customPaginate($customers, $page, $input['limit']);
        } else {
            $customers = Functions::customPaginate($customers, $page);
        }

        $categories = Category::select('id', 'name')->where('type', StatusCode::SERVICE)->get();
        $rank = $customers->firstItem();

        $url = '/customers';
        $user = Auth::user();
        $user_filter_list= array(
            0=>'STT',
            1=>'Ngày tạo KH',
            2=>'Họ tên',
            3=>'SĐT',
            4=>'Tin nhắn',
            5=>'Nhóm KH',
            6=>'Trạng thái',
            7=>'Người phụ trách',
            8=>'Mô tả',
            9=>'T/G tác nghiệp',
            10=>'Chuyển về TP',
            11=>'C.Nhánh',
            12=>'DV liên quan',
            13=>'Nhóm tính cách',
            14=>'Người tạo',
            15=>'Lịch hẹn',
            16=>'Ngày sinh',
            17=>'MKT Phụ trách',
            18=>'Nguồn KH',
            19=>'Linh FB',
            20=>'Giới tính',
            21=>'Số đơn',
            22=>'Tổng doanh thu',
            23=>'Đã thanh toán',
            24=>'Còn lại'
        );
        $user_filter_grid = UserFilterGrid::select('fields')->where('user_id', $user->id)->where('url', $url)->first();
        if ($user_filter_grid) {
            $user_filter_grid = json_decode($user_filter_grid->fields);
        } else {
            $user_filter_grid = array_keys($user_filter_list);
        }
        if ($request->ajax()) {
            return view('customers.ajax', compact('customers', 'statuses', 'rank', 'birthday','user_filter_list','user_filter_grid'));
        }

        return view('customers.index', compact('customers', 'statuses', 'rank', 'categories', 'carePageUsers', 'birthday','user_filter_grid','user_filter_list'));
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
        $user_sale = User::where('department_id', DepartmentConstant::TELESALES);
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
        $input = $request->except(['group_id', 'image', 'type_ctv']);
        if (isset($input['is_gioithieu']) && $input['is_gioithieu']) {
            $customer_gioithieu = Customer::where('phone', $input['is_gioithieu'])->first();
            $input['is_gioithieu'] = isset($customer_gioithieu) && $customer_gioithieu ? $customer_gioithieu->id : 0;
        }
        $input['mkt_id'] = $request->mkt_id;
        $input['image'] = $request->image;
        if ((int)$input['status_id'] == StatusCode::ALL) {
            $input['status_id'] = StatusCode::NEW;
        }
        if (Auth::user()->department_id == DepartmentConstant::WAITER) {
            $request->merge(['telesales_id' => Auth::user()->id]);
        }
        $input['type_ctv'] = $request->type_ctv == 'on' ? 1 : 0;
        $customer = $this->customerService->create($input);
        $this->update_code($customer);
        self::createCustomerGroup($request->group_id, $customer->id, $customer->branch_id);

        $time = Customer::timeExpired($customer->status_id);
        $time['expired_time_boolean'] = StatusConstant::CHUA_QUA_HAN;
        $customer->update($time);
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
            $this->update_code($customer);
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
        $curent_branch = Auth::user()->branch_id ? Auth::user()->branch_id : '';
        if (isset($customer) && $customer) {
            $waiters = User::whereIn('department_id', [DepartmentConstant::TECHNICIANS,DepartmentConstant::DOCTOR])
                ->when(!empty($curent_branch), function ($q) use ($curent_branch) {
                    $q->where('branch_id', $curent_branch);
                })->pluck('full_name', 'id');
        } else {
            $waiters = User::whereIn('department_id', [DepartmentConstant::TECHNICIANS,DepartmentConstant::DOCTOR])->pluck('full_name', 'id');
        }
        $location = isset(Auth::user()->branch) ? [0, Auth::user()->branch->location_id] : [0, @$customer->branch->location_id];
        $tips = Tip::whereIn('location_id', $location)->pluck('name', 'id')->toArray();

        $staff = User::where('department_id', '<>', DepartmentConstant::ADMIN)->get()->pluck('full_name', 'id')->toArray();
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
//        $progress = Task::PROGRESS;
        $departments = Department::pluck('name', 'id');
        //EndTask
        //History SMS
        $history = [];
        $customer_post = [];
        $wallet = [];
        $package = [];
        $orders = [];
        $call_center = [];
        if ($request->history_sms) {
            $history = HistorySms::where('phone',
                $request->history_sms)->orderByDesc('id')->paginate(StatusCode::PAGINATE_20);
            return view('sms.history', compact('history'));
        }
        if ($request->post) {
            $customer_post = CustomerPost::where('phone', $request->post)->where('status', '<>',
                0)->orderByDesc('id')->paginate(StatusCode::PAGINATE_20);
            return view('post.history', compact('customer_post'));
        }
        if ($request->history_wallet) {
            $wallet = WalletHistory::where('customer_id',
                $request->history_wallet)->orderByDesc('id')->paginate(StatusCode::PAGINATE_20);
            $package = PackageWallet::pluck('name', 'id')->toArray();
            return view('wallet.history', compact('wallet', 'package'));
        }
        if ($request->schedules) {
            return view('schedules.index', compact('schedules', 'id', 'staff'));
        }

        if ($request->call_center) {
            $call_center = CallCenter::where('dest_number', $request->call_center)->paginate(StatusCode::PAGINATE_20);
            return view('call_center.customer', compact('call_center'));
        }

        if ($request->tasks) {
            $tasks = Task::where('customer_id',
                $request->tasks)->orderByDesc('date_from')->paginate(StatusCode::PAGINATE_20);
            return view('tasks._form', compact('tasks'));
        }

        if ($request->albums) {
            $albums = Album::where('customer_id', $request->albums)->first();
            $albums = !empty($albums) && !empty($albums->images) ? json_decode($albums->images) : [];
            return view('albums.index', compact('albums'));
        }

        if ($request->member_id || $request->role_type || $request->the_rest || $request->page_order) {
            if (!empty($request->page_order)) {
                $request->merge(['page' => $request->page_order]);
            }
            $params = $request->only('member_id', 'role_type', 'the_rest', 'page');
            $orders = Order::search($params);
            return view('customers.order', compact('orders', 'waiters', 'tips'));
        }
        //END

        return view('customers.view_account',
            compact('title', 'docs', 'customer', 'waiters', 'schedules', 'id', 'staff', 'tasks', 'taskStatus',
                'customer_post', 'type', 'users', 'customers', 'priority', 'status', 'departments', 'history', 'wallet',
                'package', 'call_center', 'orders', 'tips'));
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
        if (isset($input['phone']) && str_contains($input['phone'], 'xxx')) {
            unset($input['phone']);
        }
        $customer = $this->customerService->update($input, $id);
        CustomerGroup::where('customer_id', $customer->id)->delete();
        self::createCustomerGroup($request->group_id, $customer->id, $customer->branch_id);


        return redirect(route('customers.index'))->with('status', 'Cập nhật khách hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Customer $customer
     *
     * @throws \Exception
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
        $checkRole = checkRoleAlready();
        $input['branch_id'] = $request->branch_id;
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        }
        $now = Carbon::now()->format('d/m/Y');
        $data = Customer::orderBy('id', 'desc')
            ->whereBetween('created_at', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ])
            ->when(isset($request->gender), function ($query) use ($request) {
                $query->where('gender', $request->gender);
            })->with('orders', 'categories');
        $data = $data->when(!empty($request->status), function ($query) use ($request) {
            $query->where('status_id', $request->status);
        })->when(!empty($input['branch_id']), function ($query) use ($input) {
            $query->where('branch_id', $input['branch_id']);
        })->when(isset($request->gender), function ($query) use ($request) {
            $query->where('gender', $request->gender);
        })->when(!empty($request->group), function ($query) use ($request) {
            $arr = CustomerGroup::select('customer_id')->where('category_id', $request->group)->whereBetween('created_at', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ]);
            if (!empty($request->branch_id)) {
                $arr = $arr->where('branch_id', $request->branch_id);
            }
            $arr = $arr->pluck('customer_id')->toArray();
            $query->whereIn('id', $arr);
        })->get();

        Excel::create('Khách hàng (' . $now . ')', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:S1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->freezeFirstRow();
                $sheet->row(1, [
                    'Ngày tạo KH',
                    'Tên khách hàng',
                    'Mã khách hàng',
                    'Số điện thoại',
                    'Sinh nhật',
                    'Giới tính',
                    'Link Facebook',
                    'Địa chỉ',
                    'Số đơn',
                    'Tổng doanh thu',
                    'Số dư ví',
                    'Người phụ trách',
                    'Nhóm khách hàng',
                    'Nguồn KH',
                    'Mối quan hệ',
                    'Mô tả',
                    'Ngày trao đổi',
                    'Nội dung trao đổi',
                    'Chi nhánh',
                ]);

                $i = 1;
                if ($data) {
                    foreach ($data as $k => $ex) {
                        $categoryName = '';
                        $i++;
                        foreach ($ex->categories as $category) {
                            $categoryName .= $category->name . ', ';
                        }
                        $comment = GroupComment::select('created_at', 'messages')->where('customer_id',
                            $ex->id)->orderByDesc('id')->take(3)->get();
                        $date_comment = count($comment) ? $comment->pluck('created_at')->toArray() : [];
                        $messages = count($comment) ? $comment->pluck('messages')->toArray() : [];
                        $date_comment = count($messages) ? implode("||", $date_comment) : '';
                        $messages = count($messages) ? implode("||", $messages) : '';
                        $sheet->row($i, [
                            @Carbon::createFromFormat('Y-m-d H:i:s', $ex->created_at)->format('d/m/Y'),
                            @$ex->full_name,
                            @$ex->account_code,
                            @$ex->phone,
                            @$ex->birthday,
                            @$ex->GenderText,
                            @$ex->facebook,
                            @$ex->address,
                            @$ex->orders->count(),
                            @(int)$ex->orders->sum('all_total'),
                            @$ex->wallet,
                            @$ex->telesale->full_name,
                            @$categoryName,
                            @$ex->source_customer->name,
                            @$ex->status->name,
                            @$ex->description,
                            $date_comment,
                            $messages,
                            @$ex->branch->name,
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
//                        $date = Carbon::createFromFormat('d/m/Y', trim($row['ngay_tao_kh']))->format('Y-m-d');
                        $date = Carbon::parse(trim($row['ngay_tao_kh']))->format('Y-m-d');
                        $status = Status::where('name', $row['moi_quan_he'])->first();
                        $telesale = User::where('full_name', 'like', '%' . $row['nguoi_phu_trach'] . '%')->first();
                        $source = Status::where('code', 'like', '%' . str_slug($row['nguon_kh']) . '%')->first();
                        $check = Customer::where('phone', $row['so_dien_thoai'])->first();
                        $category = explode(',', $row['nhom_khach_hang']);
                        $branch = Branch::where('name', $row['chi_nhanh'])->first();

                        if (empty($check)) {
                            if ($row['so_dien_thoai']) {
                                $data = Customer::create([
                                    'full_name' => $row['ten_khach_hang'],
                                    'account_code' => !empty($row['ma_khach_hang']) ? $row['ma_khach_hang'] : "KH" . ($k + 1),
                                    'mkt_id' => @Auth::user()->id,
                                    'telesales_id' => isset($telesale) ? $telesale->id : 1,
                                    'status_id' => isset($status) ? $status->id : 1,
                                    'source_id' => isset($source) ? $source->id : 18,
                                    'phone' => strlen($row['so_dien_thoai']) > 9 ? $row['so_dien_thoai'] : '0' . $row['so_dien_thoai'],
                                    'birthday' => isset($row['sinh_nhat']) ? $row['sinh_nhat'] : '',
                                    'gender' => str_slug($row['gioi_tinh']) == 'nu' ? 0 : 1,
                                    'address' => $row['dia_chi'] ?: '',
                                    'facebook' => $row['link_facebook'] ?: '',
                                    'description' => $row['mo_ta'],
                                    'wallet' => !empty($row['so_du_vi']) ? $row['so_du_vi'] : 0,
                                    'branch_id' => isset($branch) && $branch ? $branch->id : '',
                                    'created_at' => isset($date) && $date ? $date . ' 00:00:00' : Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at' => isset($date) && $date ? $date . ' 00:00:00' : Carbon::now()->format('Y-m-d H:i:s'),
                                ]);
                                if (count($category)) {
                                    foreach ($category as $item) {
                                        $field = Category::where('name', $item)->first();
                                        if (isset($field) && $field) {
                                            CustomerGroup::create([
                                                'customer_id' => $data->id,
                                                'category_id' => isset($field) ? $field->id : 0,
                                                'branch_id' => $data->branch_id,
                                                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                                            ]);
                                        }
                                    }
                                } else {
                                    CustomerGroup::create([
                                        'customer_id' => $data->id,
                                        'category_id' => 0,
                                        'branch_id' => $data->branch_id,
                                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                                    ]);
                                }

                                if (!empty($row['ngay_trao_doi']) && !empty($row['noi_dung_trao_doi'])) {
                                    GroupComment::where('customer_id', $data->id)->delete();
                                    $comment_value = [];
                                    $row['ngay_trao_doi'] = explode('||', $row['ngay_trao_doi']);
                                    $row['noi_dung_trao_doi'] = explode('||', $row['noi_dung_trao_doi']);
                                    foreach ($row['ngay_trao_doi'] as $key_date => $item) {
                                        $item = Carbon::createFromFormat('H:i d-m-Y', trim($item))->format('Y-m-d H:i');
                                        $comment_value[] = [
                                            'customer_id' => $data->id,
                                            'user_id' => Auth::user()->id,
                                            'messages' => @$row['noi_dung_trao_doi'][$key_date],
                                            'created_at' => $item,
                                            'updated_at' => $item,
                                            'branch_id' => $data->branch_id,
                                        ];
                                    }
                                    GroupComment::insertOrIgnore($comment_value);
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
        $input = $request->except('category_ids', 'category_tips');
        if (isset($input['phone'])&& str_contains($input['phone'], 'xxx')) {
            unset($input['phone']);
        }
        $before = $this->customerService->find($id);
        $data = [];
        if (isset($before) && $before) {
            $customer = $this->customerService->update($input, $id);
            SchedulesSms::where('status_customer', '<>', $customer->status_id)->delete();
            $check2 = RuleOutput::where('event', 'change_relation')->first();

            if ($customer->status_id != $before->status_id && isset($check2) && $check2) {
                $cskh = User::select('id')->where('department_id', UserConstant::PHONG_CSKH)->pluck('id')->toArray();
                $rule = $check2->rules;
                $config = @json_decode(json_decode($rule->configs))->nodeDataArray;
                $rule_status = Functions::checkRuleStatusCustomer($config);
                foreach (array_values($rule_status) as $k1 => $item) {
                    $list_status = $item->configs->group;
                    if (in_array($customer->status_id, $list_status)) {
                        $sms_ws = Functions::checkRuleSms($config);
                        if (count($sms_ws)) {
                            foreach (@array_values($sms_ws) as $k2 => $sms) {
                                $input_raw['full_name'] = @$customer->full_name;
                                $exactly_value = Functions::getExactlyTime($sms);
                                $text = $sms->configs->content;
//                                $phone = Functions::convertPhone(@$customer->phone);
                                $text = Functions::replaceTextForUser($input_raw, $text);
                                $text = Functions::vi_to_en($text);
                                if (empty($exactly_value)) {
                                    $err = Functions::sendSmsV3($customer->phone, @$text, $exactly_value);
                                    if (isset($err) && $err) {
                                        HistorySms::insert([
                                            'phone' => @$customer->phone,
                                            'campaign_id' => 0,
                                            'message' => $text,
                                            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                                            'updated_at' => Carbon::parse($exactly_value)->format('Y-m-d H:i'),
                                        ]);
                                    }
                                } else {
                                    SchedulesSms::create([
                                        'phone' => $customer->phone,
                                        'content' => @$text,
                                        'exactly_value' => Carbon::parse($exactly_value)->format('Y-m-d H:i'),
                                        'status_customer' => @$customer->status_id,
                                    ]);
                                }
                            }
                        }
                        // Tạo công việc
                        $jobs = Functions::checkRuleJob($config);

                        if (count($jobs)) {
                            foreach ($jobs as $job) {
                                if (isset($job->configs->type_job) && @$job->configs->type_job == 'cskh' && count($cskh)) {
                                    $user_id = !empty($cskh[$rule->position]) ? $cskh[$rule->position] : 0;
                                    $rule->position = ($rule->position + 1) < count($cskh) ? $rule->position + 1 : 0;
                                    $rule->save();
                                    $type = StatusCode::CSKH;
                                    $prefix = "CSKH ";

                                } else {
                                    $user_id = @$customer->telesales_id;
                                    $type = StatusCode::GOI_LAI;
                                    $prefix = "Gọi lại ";
                                }

                                $day = $job->configs->delay_value;
                                $sms_content = $job->configs->sms_content;
                                $category = @$customer->categories;
                                $text_category = [];
                                if (count($category)) {
                                    foreach ($category as $item) {
                                        $text_category[] = $item->name;
                                    }
                                }
                                $text_order = "Ngày chuyển trạng thái : " . $customer->updated_at;
                                $input = [
                                    'customer_id' => @$customer->id,
                                    'date_from' => Carbon::now()->addDays($day)->format('Y-m-d'),
                                    'time_from' => '07:00',
                                    'time_to' => '21:00',
                                    'code' => 'CSKH',
                                    'user_id' => $user_id,
                                    'all_day' => 'on',
                                    'priority' => 1,
                                    'branch_id' => @$customer->branch_id,
                                    'customer_status' => @$customer->status_id,
                                    'type' => $type,
                                    'sms_content' => Functions::vi_to_en($sms_content),
                                    'name' => $prefix . @$customer->full_name . ' - ' . @$customer->phone . ' - nhóm ' . implode(",",
                                            $text_category) . ' ,' . @$customer->branch->name,
                                    'description' => $text_order . "--" . replaceVariable($sms_content,
                                            @$customer->full_name, @$customer->phone,
                                            @$customer->branch->name, @$customer->branch->phone,
                                            @$customer->branch->address),
                                ];

                                $task = $this->taskService->create($input);
                                $follow = User::where('department_id', DepartmentConstant::ADMIN)->orWhere(function ($query) {
                                    $query->where('department_id', DepartmentConstant::TELESALES)->where('is_leader',
                                        UserConstant::IS_LEADER);
                                })->get();
                                $task->users()->attach($follow);
                                $title = $task->type == NotificationConstant::CALL ? '💬💬💬 Bạn có công việc gọi điện mới !'
                                    : '📅📅📅 Bạn có công việc chăm sóc mới !';
                                Notification::insert([
                                    'title' => $title,
                                    'user_id' => $task->user_id,
                                    'type' => $task->type,
                                    'task_id' => $task->id,
                                    'status' => NotificationConstant::HIDDEN,
                                    'created_at' => $task->date_from . ' ' . $task->time_from,
                                    'data' => json_encode((array)['task_id' => $task->id]),
                                ]);
                            }
                        }
                        // end cong viec

                    }
                }
            }
            if (isset($request->category_ids) && $request->category_ids) {
                $customer->categories()->sync($request->category_ids);
            }
            if (isset($request->category_tips) && $request->category_tips) {

                $customer->category_tips = json_encode($request->category_tips);
                $customer->save();
            }
            if (isset($data->birthday)) {
                $customer->birthday = Functions::dayMonthYear($data->birthday);
            }

            $time = Customer::timeExpired($customer->status_id);
            $time['expired_time_boolean'] = StatusConstant::CHUA_QUA_HAN;
            $customer->update($time);

            $data = Customer::with('status', 'categories', 'telesale', 'genitive')->where('id', $id)->first();

            $data->tips = $data->group_tips;
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
     *
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

        $telesales = User::whereIn('role',
            [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->get();

        return [
            'customer' => $customer,
            'data' => $telesales,
        ];
    }


    protected function createCustomerGroup($group_id, $customer_id, $branch_id)
    {
        $category = Category::find($group_id);
        if (count($category)) {
            foreach ($category as $item) {
                CustomerGroup::create([
                    'customer_id' => $customer_id,
                    'category_id' => $item->id,
                    'branch_id' => $branch_id,
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                ]);
            }
        }
    }
}
