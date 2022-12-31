<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Category;
use App\Models\City;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\HistorySms;
use App\Models\HistoryUpdateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\ProductDepot;
use App\Models\Promotion;
use App\Models\Services;
use App\Models\Status;
use App\Models\Notification;
use App\Models\Tip;
use App\Services\OrderDetailService;
use App\Services\OrderService;
use App\Services\PaymentHistoryService;
use App\Services\WalletService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RuleOutput;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use DB;
use Excel;
use Exception;
use Log;
use Illuminate\Support\Facades\View;
use App\Constants\NotificationConstant;

class OrderController extends Controller
{
    private $orderService;
    private $orderDetailService;
    private $taskService;

    /**
     * OrderController constructor.
     *
     * @param OrderService $orderService
     * @param OrderDetailService $orderDetailService
     */
    public function __construct(OrderService $orderService, OrderDetailService $orderDetailService, TaskService $taskService)
    {
        $this->middleware('permission:order.index_payment', ['only' => ['order.index_payment']]);
        $this->middleware('permission:order.orders-destroy', ['only' => ['order.orders-destroy']]);
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
        $this->taskService = $taskService;

        $services = Services::where('type', StatusCode::SERVICE)->orderBy('category_id', 'asc')->orderBy('id', 'desc')
            ->get()->pluck('name', 'id')->prepend('-Chọn dịch vụ-', '');
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id');
        $order_type = [
            Order::TYPE_ORDER_DEFAULT => 'Đơn thường',
            Order::TYPE_ORDER_ADVANCE => 'Liệu trình',
        ];

        $branchs = Branch::search()->pluck('name', 'id');
        $city = City::pluck('name', 'id');
        view()->share([
            'services' => $services,
            'status' => $status,
            'order_type' => $order_type,
            'branchs' => $branchs,
            'city'  => $city
        ]);
    }

//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

    /**
     * Display orders
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $customerId = $request->customer_id;
        $customer = Customer::find($customerId);
        $spaTherapissts = User::where('department_id', DepartmentConstant::DOCTOR)->pluck('full_name', 'id');
        $customer_support = User::whereIn('department_id', [DepartmentConstant::TECHNICIANS, DepartmentConstant::WAITER])->pluck('full_name',
            'id');
        $title = 'Tạo đơn hàng';
//        $services = Services::where('type', StatusCode::SERVICE)->with('category')->get();
        $products = Services::where('type', StatusCode::PRODUCT)->with('category')->get();
//        $combo = Services::whereIn('type', [StatusCode::PRODUCT, StatusCode::SERVICE])->with('category')->get();
        $customers = Customer::pluck('full_name', 'id');
        return view('order.index',
            compact('title', 'customers', 'customer', 'spaTherapissts', 'customer_support', 'products'));
    }

    /**
     * Tao đơn dịch vụ
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexService(Request $request)
    {
        $customerId = $request->customer_id;
        $customer = Customer::find($customerId);
        $spaTherapissts = User::where('department_id', DepartmentConstant::DOCTOR)->pluck('full_name', 'id');
        $customer_support = User::whereIn('department_id', [DepartmentConstant::TECHNICIANS, UserConstant::WAITER])->pluck('full_name',
            'id');
        $title = 'Tạo đơn hàng';
        $products = Services::where('type', StatusCode::PRODUCT)->with('category')->withTrashed()->get();
        $services = Services::where('type', StatusCode::SERVICE)->with('category')->withTrashed()->get();
        $combo = Services::with('category')->withTrashed()->get();
        $customers = Customer::pluck('full_name', 'id');
        return view('order.indexService',
            compact('title', 'customers', 'customer', 'spaTherapissts', 'customer_support', 'services', 'products', 'combo'));
    }

    public function getInfoService(Request $request)
    {
        $id = $request->id ? $request->id : '';
        if (isset($id) && $id) {
            $data = Services::find($id);
            return $data;
        }
    }

    public function getInfoCustomer(Request $request)
    {
        $id = $request->id ? $request->id : '';
        if (isset($id) && $id) {
            $data = Customer::find($id);
            return $data;
        }
    }

    public function store(Request $request)
    {
        $customer = Customer::find($request->user_id);
        $param = $request->all();

        $param['count_day'] = isset($param['days']) && count($param['days']) ? array_sum($param['days']) : 0;
        $inputCustomer = $request->only('full_name', 'phone', 'address', 'status_id');
        if (str_contains($inputCustomer['phone'], 'xxx')) {
            unset($inputCustomer['phone']);
        }
        $customer->update($inputCustomer);
        $param['branch_id'] = !empty(Auth::user()->branch_id) ? Auth::user()->branch_id : $customer->branch_id;
        $param['mkt_id'] = $customer->mkt_id ?: 0;
        $param['carepage_id'] = $customer->carepage_id ?: 0;
        $param['telesale_id'] = $customer->telesales_id ?: 0;
        DB::beginTransaction();
        try {
            $param['source_id'] = $customer->source_id ?: 0;
            $order = $this->orderService->create($param);
            if (!$order) {
                DB::rollBack();
            }
            $countOrders = Order::select('id')->where('member_id', $customer->id)->whereIn('role_type', [StatusCode::COMBOS, StatusCode::SERVICE])->count();
            if (@$countOrders >= 2) {
                $customer->old_customer = 1;
                $customer->save();
                $order->is_upsale = 1;
                $order->save();
            }

            if ($order->discount > 0) {
                $promotion = Promotion::find($order->voucher_id);
                $promotion->current_quantity = $promotion->current_quantity - 1;
                $promotion->save();
            }

            if (isset($request->spa_therapisst_id) && $request->spa_therapisst_id != 0) {
                foreach ($param['days'] as $k => $item) {
                    if ($item > 0) {
                        HistoryUpdateOrder::create([
                            'user_id' => $request->spa_therapisst_id,
                            'order_id' => $order->id,
                            'branch_id' => !empty(Auth::user()->branch_id) ? Auth::user()->branch_id : $customer->branch_id,
                            'service_id' => $param['service_id'][$k] ?: 0,
                        ]);
                    }
                }

            }

            $orderDetail = $this->orderDetailService->create($param, $order->id);

            if (!$orderDetail) {
                DB::rollBack();
            }

            DB::commit();
            return redirect('/order/' . $order->id . '/show')->with('status', 'Tạo đơn hàng thành công');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            $debug = 'Try catch exception : ' . $e->getMessage() . 'LINE : ___' . $e->getLine() . '___FILE___' . $e->getFile();
            return ApiResult(500, 'Insert failed', null, null, $debug);
        }
    }

    public function listOrder(Request $request)
    {
        $title = 'ĐƠN HÀNG BÁN';
        $input = $request->all();
        $checkRole = checkRoleAlready();
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        }
        $group = Category::pluck('name', 'id')->toArray();
        $gifts = ProductDepot::select('product_id')->with('product')->has('product')->groupBy('product_id')->get()->map(function ($item) {
            $item->name = @$item->product->name;
            return $item;
        })->pluck('name', 'product_id')->toArray();
        $marketingUsers = User::where('department_id', DepartmentConstant::MARKETING)->pluck('full_name', 'id')->toArray();
        $ktvUsers = User::where('department_id', DepartmentConstant::TECHNICIANS)->pluck('full_name', 'id')->toArray();
        $telesales = User::where('department_id', DepartmentConstant::TELESALES)->pluck('full_name', 'id')->toArray();
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $check_null = $this->checkNull($request);
        if ($check_null == StatusCode::NOT_NULL) {

            $orders = Order::searchAll($input);
            View::share([
                'allTotal' => $orders->sum('all_total'),
                'grossRevenue' => $orders->sum('gross_revenue'),
                'theRest' => $orders->sum('the_rest'),
            ]);
            if (isset($request->download)) {
                $orders2 = $orders->with('historyUpdateOrders')->get();
                Excel::create('Đơn hàng (' . date("d/m/Y") . ')', function ($excel) use ($orders2) {
                    $excel->sheet('Sheet 1', function ($sheet) use ($orders2) {
                        $sheet->cell('A1:P1', function ($row) {
                            $row->setBackground('#008686');
                            $row->setFontColor('#ffffff');
                        });
                        $sheet->freezeFirstRow();
                        $sheet->row(1, [
                            'STT',
                            'Ngày đặt hàng',
                            'Ngày hết hạn',
                            'Mã ĐH',
                            'Tên KH',
                            'SĐT',
                            'Sản phẩm|Dịch vụ',
                            'Số lượng (nếu có)',
                            'Doanh số',
                            'Doanh thu',
                            'Còn nợ',
                            'Khuyến mại (voucher)',
                            'Hình thức thanh toán',
                            'Ngày thanh toán',
                            'Người lên đơn',
                            'KTV liệu trình',
                            'Buổi còn lại',
                            'Dịch vụ',
                            'Loại',
                            'Ngày làm LT',
                            'Chi nhánh',
                        ]);
                        $i = 1;
                        if ($orders2) {
                            foreach ($orders2 as $k => $ex) {
                                $ktv = [];
                                $service = [];
                                $type = [];
                                $updated = [];
                                if (isset($ex->historyUpdateOrders) && count($ex->historyUpdateOrders)) {
                                    $ktv = [];
                                    $service = [];
                                    $type = [];
                                    foreach ($ex->historyUpdateOrders as $item) {
                                        $user = User::find($item->user_id);
                                        if (isset($user) && $user) {
                                            $ktv[] = $user->full_name;
                                            $service[] = @$item->service->name;
                                            $type[] = @$item->type;
                                            $updated[] = @date('Y-m-d H:i', strtotime($item->updated_at));
                                        }
                                    }
                                }

                                $history_payment = PaymentHistory::where('order_id', $ex->id)->first();
                                $payment_type = @$history_payment->payment_type == 1 ? 'Tiền mặt' : (@$history_payment->payment_type == 2 ? 'Thẻ' : (@$history_payment->payment_type == 3 ? 'Điểm' : 'Chuyển khoản'));
                                $date = !empty($history_payment) ? Carbon::createFromFormat('Y-m-d', $history_payment->payment_date)->format('d/m/Y') : '';

                                $i++;
                                $sheet->row($i, [
                                    @$k + 1,
                                    isset($ex->created_at) ? date("d/m/Y", strtotime($ex->created_at)) : '',
                                    isset($ex->hsd) ? date("d/m/Y", strtotime($ex->hsd)) : '',
                                    @$ex->code,
                                    @$ex->customer->full_name,
                                    @$ex->customer->phone,
                                    @str_replace('<br>', ',', $ex->service_text),
                                    @$ex->orderDetails->sum('quantity'),
                                    @number_format($ex->all_total),
                                    @number_format($ex->gross_revenue),
                                    @number_format($ex->the_rest),
                                    @number_format($ex->discount),
                                    $payment_type,
                                    $date,
                                    @$ex->customer->marketing->full_name,
                                    count($ktv) ? implode("||", $ktv) : '',
                                    $ex->count_day,
                                    count($service) ? implode("||", $service) : '',
                                    count($type) ? implode("||", $type) : '',
                                    count($updated) ? implode("||", $updated) : '',
                                    @$ex->branch->name,
                                ]);
                            }
                        }
                    });
                })->export('xlsx');
            }

            $orders = $orders->orderBy('id', 'desc')->paginate(StatusCode::PAGINATE_20);
            View::share([
                'allTotalPage' => $orders->sum('all_total'),
                'grossRevenuePage' => $orders->sum('gross_revenue'),
                'theRestPage' => $orders->sum('the_rest'),
            ]);

        } else {
            $now = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            $orders = Order::whereYear('created_at', $year)->whereMonth('created_at',
                $now)->with('orderDetails')
                ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->orderBy('id', 'desc');
            View::share([
                'allTotal' => $orders->sum('all_total'),
                'grossRevenue' => $orders->sum('gross_revenue'),
                'theRest' => $orders->sum('the_rest'),
            ]);
            $orders = $orders->paginate(StatusCode::PAGINATE_20);
            View::share([
                'allTotalPage' => $orders->sum('all_total'),
                'grossRevenuePage' => $orders->sum('gross_revenue'),
                'theRestPage' => $orders->sum('the_rest'),
            ]);
        }

        $rank = $orders->firstItem();
        if ($request->ajax()) {
            return Response::json(view('order-details.ajax',
                compact('orders', 'title', 'rank', 'gifts'))->render());
        }

        return view('order-details.index',
            compact('orders', 'title', 'group', 'marketingUsers', 'telesales', 'source', 'rank', 'ktvUsers', 'gifts'));
    }

    /**
     * Đã thu trong kỳ
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function listOrderPayment(Request $request)
    {
        $title = 'ĐƠN THU TRONG KỲ';
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $checkRole = checkRoleAlready();
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        }
        $group = Category::select('id', 'name')->pluck('name', 'id')->toArray();
        $marketingUsers = User::select('id', 'full_name')->pluck('full_name', 'id')->toArray();
        $telesales = User::select('id', 'full_name')->whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])
            ->pluck('full_name', 'id')->toArray();
        $source = Status::select('id', 'name')->where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $check_null = $this->checkNull($request);
        if ($check_null == StatusCode::NOT_NULL) {
            $detail = PaymentHistory::search($input);
            View::share([
                'allTotal' => $detail->sum('price'),
            ]);
            $detail = $detail->orderBy('id', 'desc')->paginate(StatusCode::PAGINATE_20);
            View::share([
                'allTotalPage' => $detail->sum('price'),
            ]);

        } else {
            $input = [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ];
            $detail = PaymentHistory::search($input);

            View::share([
                'allTotal' => $detail->sum('price'),
            ]);
            $detail = $detail->paginate(StatusCode::PAGINATE_20);
            View::share([
                'allTotalPage' => $detail->sum('price'),
            ]);
        }

        $rank = $detail->firstItem();
        $orders = $detail;
        if ($request->ajax()) {
            return Response::json(view('order-details.ajax-payment',
                compact('orders', 'title', 'rank'))->render());
        }

        return view('order-details.index-payment',
            compact('orders', 'title', 'group', 'marketingUsers', 'telesales', 'source', 'rank'));
    }


    public function show($id)
    {
        $curent_branch = Auth::user()->branch_id ? Auth::user()->branch_id : '';
        $location = isset(Auth::user()->branch) ? [0, Auth::user()->branch->location_id] : [0, @$customer->branch->location_id];
        $tips = Tip::whereIn('location_id', $location)->pluck('name', 'id')->toArray();
        if (isset($curent_branch) && $curent_branch) {
            $waiters = User::where('department_id', DepartmentConstant::TECHNICIANS)
                ->when(!empty($curent_branch), function ($q) use ($curent_branch) {
                    $q->where('branch_id', $curent_branch);
                })->pluck('full_name', 'id');
        } else {
            $waiters = User::where('department_id', DepartmentConstant::TECHNICIANS)->pluck('full_name', 'id');
        }
        $products = Services::select('id', 'name')->where('type', StatusCode::PRODUCT)->pluck('name', 'id')->toArray();
        $order = Order::with('customer', 'orderDetails', 'paymentHistories')->findOrFail($id);
        $now = Carbon::now()->format('d-m-Y');
        $order->now = $now;
        $payment = $order->paymentHistories;
        return view('order.order', compact('order', 'payment', 'products', 'waiters', 'tips'));
    }

    /**
     * Hiển thị đơn dịch vụ
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showService($id)
    {
        $order = Order::with('customer', 'orderDetails', 'paymentHistories')->findOrFail($id);
        $now = Carbon::now()->format('d-m-Y');
        $order->now = $now;
        $data = $order->paymentHistories;
        return view('order.orderService', compact('order', 'data'));
    }

    public function destroy(Request $request, $id)
    {
        $payment = PaymentHistory::where('order_id', $id)->get();
        if (isset($payment) && count($payment)) {
            $request->session()->flash('warning', 'Vui lòng xoá thanh toán đơn hàng trước khi xoá đơn !!!');
        } else {
            $this->orderService->delete($id);
            $request->session()->flash('error', 'Xóa đơn hàng thành công!');
        }
    }

    public function orderDetailPdf($id)
    {
        $order = Order::with('customer', 'orderDetails')->findOrFail($id);
        $payment = PaymentHistory::where('order_id', $order->id)->latest()->first();
        return view('order.order-pdf', compact('order', 'payment'));
    }

    public function payment(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $input = $request->except('customer_id');
            $customer = Customer::find($request->customer_id);
            $input['branch_id'] = !empty(Auth::user()->branch_id) ? Auth::user()->branch_id : $customer->branch_id;
            $paymentHistory = PaymentHistoryService::create($input, $id);

            if ($paymentHistory->payment_type != 3) {
                $point = $paymentHistory->price / StatusCode::EXCHANGE_POINT * StatusCode::EXCHANGE_MONEY;
            } else {
                $point = ($customer->wallet - $paymentHistory->price) > 0 ? $customer->wallet - $paymentHistory->price : 0;
            }

            $customer->wallet = $point;
            $customer->save();
            $order = $this->orderService->updatePayment($input, $id);
            if (!$paymentHistory || !$order) {
                DB::rollBack();
            }
            DB::commit();

            $group_customer = CustomerGroup::where('customer_id', $customer->id)->pluck('category_id')->toArray();
            $check = PaymentHistory::where('branch_id', $customer->branch_id)->where('order_id', $id)->get();
            $check2 = RuleOutput::where('event', 'add_order')->groupBy('rule_id')->whereIn('category_id',
                $group_customer)->get();

            if (setting('exchange') > 0 && isset($customer->gioithieu) && $customer->gioithieu->id) {
                WalletService::exchangeWalletCtv($paymentHistory->price, $customer->gioithieu->id, $paymentHistory->id);
            }

            if (count($check) <= 1 && isset($check2) && count($check2)) {
                $check3 = PaymentHistory::where('branch_id', $customer->branch_id)->where('order_id', $id)->first();
                foreach ($check2 as $item) {
                    if (@$item->rules->status == StatusCode::ON) {
                        $rule = $item->rules;
                        $config = @json_decode(json_decode($rule->configs))->nodeDataArray;
                        $sms_ws = Functions::checkRuleSms($config);
                        if (count($sms_ws)) {
                            foreach ($sms_ws as $sms) {
                                $input_raw['branch'] = @$check3->order->branch->name;
                                $input_raw['phoneBranch'] = @$check3->order->branch->phone;
                                $input_raw['addressBranch'] = @$check3->order->branch->address;
                                $input_raw['full_name'] = @$check3->order->customer->full_name;
                                $input_raw['phone'] = @$check3->order->customer->phone;
                                $exactly_value = Functions::getExactlyTime($sms);
                                $text = $sms->configs->content;
                                $phone = Functions::convertPhone($input_raw['phone']);
                                $text = Functions::replaceTextForUser($input_raw, $text);
                                $text = Functions::vi_to_en($text);
                                try {
                                    $err = Functions::sendSmsV3($phone, @$text, $exactly_value);
                                    if (isset($err) && $err) {
                                        HistorySms::insert([
                                            'phone' => $input_raw['phone'],
                                            'campaign_id' => 0,
                                            'message' => $text,
                                            'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                                            'updated_at' => Carbon::parse($exactly_value)->format('Y-m-d H:i'),
                                        ]);
                                    }
                                } catch (Exception $exception) {

                                }

                            }
                        }
                        $jobs = Functions::checkRuleJob($config);
                        if (count($jobs) && $order->role_type != StatusCode::PRODUCT) { //add thêm role type
                            foreach ($jobs as $job) {
                                if ($job->configs->type_job && @$job->configs->type_job == 'cskh' && count($cskh)) {
                                    $user_id = !empty($cskh[$rule->position]) ? $cskh[$rule->position] : 0;
                                    $rule->position = ($rule->position + 1) < count($cskh) ? $rule->position + 1 : 0;
                                    $rule->save();
                                    $type = StatusCode::CSKH;
                                    $prefix = "CSKH ";
                                } else {
                                    $user_id = @$customer->telesales_id;
                                    $type = StatusCode::CSKH;
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
                                $text_order = "Ngày tạo đơn: " . $check3->order->created_at . ' Đơn hàng: ' . number_format($check3->order->all_total) . " Đã thanh toán: "
                                    . number_format($check3->order->gross_revenue) . " Còn nợ : " . number_format($check3->order->the_rest)
                                    . "--Các dịch vụ :" . @str_replace('<br>', "|", @$check3->order->service_text);
                                $input = [
                                    'customer_id' => @$customer->id,
                                    'date_from' => Carbon::now()->addDays($day)->format('Y-m-d'),
                                    'time_from' => '07:00',
                                    'time_to' => '21:00',
                                    'code' => 'CSKH',
                                    'user_id' => @$user_id,
                                    'all_day' => 'on',
                                    'priority' => 1,
                                    'branch_id' => @$check3->order->branch_id,
                                    'type' => $type,
                                    'sms_content' => Functions::vi_to_en($sms_content),
                                    'name' => $prefix . @$check3->order->customer->full_name . ' - ' . @$check3->order->customer->phone . ' - nhóm ' . implode(",", $text_category) . ' ,' . @$check3->order->branch->name,
                                    'description' => $text_order . "--" . replaceVariable($sms_content,
                                            @$check3->order->customer->full_name, @$check3->order->customer->phone,
                                            @$check3->order->branch->name, @$check3->order->branch->phone,
                                            @$check3->order->branch->address),
                                ];

                                $task = $this->taskService->create($input);
                                $follow = User::where('department_id', DepartmentConstant::ADMIN)->orWhere(function ($query) {
                                    $query->where('role', UserConstant::TELESALES)->where('is_leader',
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

                    }
                }
            }
            DB::commit();

            Functions::updateRank($customer->id);
            return $order; //comment
        } catch (\Exception $e) {
//            DB::rollBack();
            Log::error($e);
            $debug = 'Try catch exception : ' . $e->getMessage() . 'LINE : ___' . $e->getLine() . '___FILE___' . $e->getFile();
            return ApiResult(500, 'Insert failed', null, null, $debug);
        }
    }


    public function infoPayment(Request $request, $id)
    {
        return $this->orderService->getPayment($request->all(), $id);
    }

    public function reportProduct()
    {
        $title = "THỐNG KÊ SẢN PHẨM";
        $arr = Services::getIdServiceType(StatusCode::SERVICE);
        $services = Services::handleChart($arr);
        return view('report_products.chart', compact('title', 'services'));
    }

    public function updateCountDay(Request $request, $id)
    {
        $order = $this->orderService->find($id);
        if ($order->type === Order::TYPE_ORDER_ADVANCE && $order->count_day === 0) {
            return "Failed";
        }
        HistoryUpdateOrder::create([
            'user_id' => $request->user_id,
            'support_id' => isset($request->support_id) && $request->support_id ? $request->support_id : '',
            'support2_id' => isset($request->support2_id) && $request->support2_id ? $request->support2_id : '',
            'order_id' => $order->id,
            'service_id' => $request->service_id,
            'type' => $request->type_delete,
            'tip_id' => $request->tip_id ?: 0,
            'description' => $request->description,
            'branch_id' => !empty(Auth::user()->branch_id) ? Auth::user()->branch_id : $order->branch_id,
        ]);

        if ($request->type_delete == StatusCode::TYPE_ORDER_PROCESS) {
            $order->count_day = $order->count_day - 1;
            $order->save();
            $order_detail = OrderDetail::where('order_id', $order->id)->where('booking_id',
                $request->service_id)->first();
            $order_detail->days = $order_detail->days - 1 > 0 ? $order_detail->days - 1 : 0;
            $order_detail->save();
        }

        return "Success";
    }

    /**
     * Sum process order /Cộng buổi liệu trình
     *
     * @param Request $request
     * @param         $id
     *
     * @return string
     */
    public function sumCountDay(Request $request, $id)
    {
        $order = $this->orderService->find($id);

        if ($order->type === Order::TYPE_ORDER_ADVANCE && $order->count_day == 0) {
            return "Failed";
        }

        if ($request->type == StatusCode::TYPE_ORDER_PROCESS) {
            $order->count_day = $order->count_day + 1;
            $order->save();
        }

        HistoryUpdateOrder::where('id', $request->history_id)->delete();

        return "Success";
    }

    /**
     * Get order by id
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderById(Request $request, $id)
    {
        $order = Order::with('historyUpdateOrders.user', 'historyUpdateOrders.support', 'historyUpdateOrders.support2', 'historyUpdateOrders.service', 'customer',
            'orderDetails.service', 'orderDetails')->find($id);

        return Response::json($order);

    }

    public function find($id)
    {
        $data = $this->orderService->orderDetail($id);

        return \response()->json($data);
    }

    public function edit($id)
    {
        $order = $this->orderService->find($id);

        $spaTherapissts = User::where('department_id', DepartmentConstant::DOCTOR)->pluck('full_name', 'id');
        $customer_support = User::whereIn('role', [DepartmentConstant::TECHNICIANS, DepartmentConstant::WAITER])->pluck('full_name',
            'id');
        $title = 'Cập nhật đơn hàng';
        $customers = Customer::pluck('full_name', 'id');
        $customerId = $order->member_id;
        $customer = Customer::where('id', $customerId)->first();
        $services = Services::where('type', StatusCode::SERVICE)->with('category')->get();
        $products = Services::where('type', StatusCode::PRODUCT)->with('category')->get();
        $combo = Services::where('type', StatusCode::COMBOS)->with('category')->get();
        $role_type = $order->role_type;

        return view('order.index',
            compact('order', 'spaTherapissts', 'customer_support', 'title', 'customers', 'customer', 'services',
                'products', 'role_type', 'combo'));
    }

    /**
     * Hiển thị đơn Dịch vụ & combos
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editService($id)
    {
        $order = $this->orderService->find($id);

        $spaTherapissts = User::where('department_id', DepartmentConstant::DOCTOR)->pluck('full_name', 'id');
        $customer_support = User::whereIn('department_id', [DepartmentConstant::TECHNICIANS, DepartmentConstant::WAITER])->pluck('full_name',
            'id');
        $title = 'Cập nhật đơn hàng';
        $customers = Customer::pluck('full_name', 'id');
        $customerId = $order->member_id;
        $customer = Customer::where('id', $customerId)->first();
        $services = Services::where('type', StatusCode::SERVICE)->with('category')->get();
        $products = Services::where('type', StatusCode::PRODUCT)->with('category')->get();
        $combo = Services::with('category')->get();
        $role_type = $order->role_type;

        return view('order.indexService',
            compact('order', 'spaTherapissts', 'customer_support', 'title', 'customers', 'customer', 'services',
                'products', 'role_type', 'combo'));
    }

    /**
     * Update orders
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $input['count_day'] = isset($input['days']) && count($input['days']) ? array_sum($input['days']) : 0;
//        if ($input['role_type'] == StatusCode::COMBOS) {
//            $check = $this->orderService->find($id);
//            $combo = Services::find($input['service_id'][0]);
//            $date = strtotime('+' . $combo->hsd . ' months', strtotime($check->created_at));
//            $date = date("Y-m-d", $date);
//            $input['hsd'] = $date;
//        }
        $customer = Customer::find($request->user_id);
        $customer->update($request->only('full_name', 'phone', 'address', 'status_id'));

        DB::beginTransaction();
        try {
            $order = $this->orderService->update($id, $input);
            if (!$order) {
                DB::rollBack();
            }

            OrderDetail::where('order_id', $id)->delete();
            $orderDetail = $this->orderDetailService->update($input, $id);

            if (!$orderDetail) {
                DB::rollBack();
            }

            DB::commit();
            return redirect('/order/' . $order->id . '/show');

        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function importDataByExcel(Request $request)
    {
        if ($request->hasFile('file')) {
            Excel::load($request->file('file')->getRealPath(), function ($render) {
                $result = $render->toArray();
                foreach ($result as $k => $row) {
                    $row['doanh_so'] = str_replace(',', '', $row['doanh_so']);
                    $row['doanh_thu'] = str_replace(',', '', $row['doanh_thu']);
                    $row['con_no'] = str_replace(',', '', $row['con_no']);
                    $row['khuyen_mai_voucher'] = str_replace(',', '', $row['khuyen_mai_voucher']);
                    $name_services = explode(',', $row['san_phamdich_vu']);
                    $customer = Customer::where('phone', $row['sdt'])->first();
                    $service = Services::whereIn('name', $name_services)->get();
                    $branch = Branch::where('name', $row['chi_nhanh'])->first();
                    if ($row['ma_dh']) {
                        $checkOrder = Order::where('code', $row['ma_dh'])->first();
                    } else {
                        $checkOrder = null;
                    }
                    $paymentType = null;

                    if ($row['hinh_thuc_thanh_toan'] == null) {
                        $paymentType = 1;
                    } elseif ($row['hinh_thuc_thanh_toan'] == "Tiền mặt") {
                        $paymentType = 1;
                    } elseif ($row['hinh_thuc_thanh_toan'] == "Thẻ") {
                        $paymentType = 2;
                    } elseif ($row['hinh_thuc_thanh_toan'] == "Chuyển khoản") {
                        $paymentType = 4;
                    } else {
                        $paymentType = 3;
                    }
                    if ($row['ngay_thanh_toan']) {
                        $payment_date = Carbon::createFromFormat('d/m/Y',
                            substr($row['ngay_thanh_toan'], 0, 10))->format('Y-m-d');
                    } else {
                        $payment_date = Carbon::now()->format('Y-m-d');
                    }
                    if (!empty($service)) {
                        if (!empty($customer) && empty($checkOrder)) {
                            $order = Order::create([
                                'code' => $row['ma_dh'],
                                'member_id' => $customer->id,
                                'all_total' => $row['doanh_so'],
                                'count_day' => $row['buoi_con_lai'] ?: 0,
                                'the_rest' => $row['con_no'],
                                'description' => @$row['mo_ta'],
                                'gross_revenue' => $row['doanh_thu'],
                                'payment_type' => $paymentType,
                                'payment_date' => $payment_date,
                                'branch_id' => isset($branch) && $branch ? $branch->id : '',
                                'type' => empty($row['ktv_lieu_trinh']) ? Order::TYPE_ORDER_DEFAULT : Order::TYPE_ORDER_ADVANCE,
                                'spa_therapisst_id' => '',
                                'created_at' => Carbon::createFromFormat('d/m/Y',
                                    $row['ngay_dat_hang'])->format('Y-m-d'),
                            ]);
                        } else {
                            $order = isset($checkOrder) && $checkOrder ? $checkOrder : 0;
                        }

                        if (!empty($customer) && count($service) && !empty($order) && empty($checkOrder)) {
                            foreach ($service as $item) {
                                OrderDetail::create([
                                    'order_id' => $order->id,
                                    //                                'code' => !empty($row['ma_sp']) ? $row['ma_sp'] : '',
                                    'booking_id' => $item->id,
                                    'quantity' => 1,
                                    'total_price' => $item->price_sell,
                                    'user_id' => $customer ? $customer->id : $order->member_id,
                                    'address' => $customer ? $customer->address : '',
                                    'vat' => 0,
                                    'percent_discount' => 0,
                                    'number_discount' => '',
                                    'price' => $item->price_sell,
                                    'branch_id' => $customer->branch_id,
                                    'days' => 0,
                                ]);
                            }

                            if ($row['doanh_thu'] > 0) {
                                PaymentHistory::create([
                                    'order_id' => $order->id,
                                    'price' => $row['doanh_thu'],
                                    'branch_id' => $customer->branch_id,
                                    'payment_date' => $payment_date,
                                ]);
                            }

                            if (!empty($row['ktv_lieu_trinh']) && !empty($row['dich_vu'])) {
                                $ktv = explode('||', $row['ktv_lieu_trinh']);
                                $dv_ktv = explode('||', $row['dich_vu']);
                                $type = explode('||', $row['loai']);
                                $date_lt = explode('||', $row['ngay_lam_lt']);
                                $dv_ktvs = Services::whereIn('name', $dv_ktv)->get();
                                foreach ($dv_ktvs as $k2 => $i_service) {
                                    if (isset($ktv[$k2]) && $ktv[$k2]) {
                                        $curentUser = User::select('id')->where('full_name', 'like',
                                            '%' . $ktv[$k2] . '%')->first();
                                    }
                                    $currentId = isset($curentUser) && $curentUser ? $curentUser->id : Auth::user()->id;
                                    HistoryUpdateOrder::insert([
                                        'user_id' => @$currentId,
                                        'order_id' => @$order->id,
                                        'service_id' => @$i_service->id,
                                        'created_at' => @$date_lt[$k2],
                                        'branch_id' => @$customer->branch_id,
                                        'type' => @$type[$k2],
                                    ]);
                                }


                            }
                        }
                    }

                }
            });

            return redirect()->back()->with('status', 'Tải đơn hàng thành công');
        }
    }

    public function checkUniqueCode(Request $request)
    {
        $order = Order::where('code', $request->code)->first();

        if ($order) {
            return $order->id == $request->id ? 'true' : 'false';
        }

        return 'true';
    }

    public function deletePayment($id)
    {
        $order = $this->orderService->deletePayment($id);

        return redirect('order/' . $order->id . '/show')->with('status', 'Xoá lịch sử thanh toán thành công');
    }

    public function checkNull($request)
    {
        if (!isset($request->group) && !isset($request->telesales) && !isset($request->marketing)
            && !isset($request->customer) && !isset($request->service) && !isset($request->payment_type)
            && !isset($request->data_time) && !isset($request->start_date) && !isset($request->end_date)
            && !isset($request->order_type) && !isset($request->phone) && !isset($request->bor_none)
            && !isset($request->role_type) && !isset($request->branch_id) && !isset($request->gifts)) {
            return 1;

        } else {
            return 0;
        }
    }

    public function updateType(Request $request, $id)
    {
        $order = $this->orderService->find($id);

        $order->update([
            'type' => $request->type,
        ]);

        $map = [
            Order::TYPE_ORDER_PROCESS => 'Trong liệu trình',
            Order::TYPE_ORDER_GUARANTEE => 'Đã bảo hành',
            Order::TYPE_ORDER_RESERVE => 'Đang bảo lưu',
        ];

        return $map[$order->type] ?? null;
    }

    public function getOrderDestroy(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $orders = Order::searchAll($input)->onlyTrashed();
        View::share([
            'allTotal' => $orders->sum('all_total'),
            'allGross' => $orders->sum('gross_revenue'),
        ]);
        $datas = $orders->orderBy('id', 'desc')->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('OrderDestroy.ajax', compact('datas'));
        }
        return view('OrderDestroy.index', compact('datas'));
    }
}
