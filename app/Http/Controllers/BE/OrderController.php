<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
use App\Models\Customer;
use App\Models\HistorySms;
use App\Models\HistoryUpdateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Services;
use App\Models\Status;
use App\Services\CustomerService;
use App\Services\OrderDetailService;
use App\Services\OrderService;
use App\Services\PaymentHistoryService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RuleOutput;
use App\Services\TaskService;
use App\Models\Rule;
use Illuminate\Support\Facades\Response;
use DB;
use Excel;
use Exception;
use Log;
use Illuminate\Support\Facades\View;

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
    public function __construct(
        OrderService $orderService,
        OrderDetailService $orderDetailService,
        TaskService $taskService
    )
    {
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
        view()->share([
            'services' => $services,
            'status' => $status,
            'order_type' => $order_type,
        ]);
    }

    public function index(Request $request)
    {
        $customerId = $request->customer_id;
        $customer = Customer::find($customerId);
        $spaTherapissts = User::where('role', UserConstant::TECHNICIANS)->pluck('full_name', 'id');
        $title = 'Tạo đơn hàng';
        $services = Services::where('type', StatusCode::SERVICE)->with('category')->get();
        $products = Services::where('type', StatusCode::PRODUCT)->with('category')->get();
        $combo = Services::where('type', StatusCode::COMBOS)->with('category')->get();
        $customers = Customer::pluck('full_name', 'id');
        return view('order.index', compact('title', 'customers', 'customer', 'spaTherapissts', 'services', 'products', 'combo'));
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
        if ($param['role_type'] == StatusCode::COMBOS) {
            $combo = Services::find($param['service_id'][0]);
            $param['hsd'] = Carbon::now('Asia/Ho_Chi_Minh')->addMonth($combo->hsd)->format('Y-m-d');
        }

        $customer->update($request->only('full_name', 'phone', 'address', 'status_id'));

        DB::beginTransaction();
        try {

            $order = $this->orderService->create($param);

            if (!$order) {
                DB::rollBack();
            }

            if (isset($request->spa_therapisst_id)) {
                HistoryUpdateOrder::create([
                    'user_id' => $request->spa_therapisst_id,
                    'order_id' => $order->id,
                ]);
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
        $group = Category::pluck('name', 'id')->toArray();
        $marketingUsers = User::pluck('full_name', 'id')->toArray();
        $telesales = User::where('role', UserConstant::TELESALES)->pluck('full_name', 'id')->toArray();
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $check_null = $this->checkNull($request);
        if ($check_null == StatusCode::NOT_NULL) {
            $orders = Order::searchAll($request->all());

            View::share([
                'allTotal' => $orders->sum('all_total'),
                'grossRevenue' => $orders->sum('gross_revenue'),
                'theRest' => $orders->sum('the_rest'),
            ]);
            $orders = $orders->orderBy('id', 'desc')->paginate(20);
            View::share([
                'allTotalPage' => $orders->sum('all_total'),
                'grossRevenuePage' => $orders->sum('gross_revenue'),
                'theRestPage' => $orders->sum('the_rest'),
            ]);

        } else {
            $now = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            $orders = Order::whereYear('created_at', $year)->whereMonth('created_at',
                $now)->with('orderDetails')->orderBy('id', 'desc');
            View::share([
                'allTotal' => $orders->sum('all_total'),
                'grossRevenue' => $orders->sum('gross_revenue'),
                'theRest' => $orders->sum('the_rest'),
            ]);
            $orders = $orders->paginate(20);
            View::share([
                'allTotalPage' => $orders->sum('all_total'),
                'grossRevenuePage' => $orders->sum('gross_revenue'),
                'theRestPage' => $orders->sum('the_rest'),
            ]);
        }

        $rank = $orders->firstItem();
        if ($request->ajax()) {
            return Response::json(view('order-details.ajax',
                compact('orders', 'title', 'rank'))->render());
        }

        return view('order-details.index',
            compact('orders', 'title', 'group', 'marketingUsers', 'telesales', 'source', 'rank'));
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
        $group = Category::pluck('name', 'id')->toArray();
        $marketingUsers = User::pluck('full_name', 'id')->toArray();
        $telesales = User::whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])
            ->pluck('full_name', 'id')->toArray();
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $check_null = $this->checkNull($request);
        if ($check_null == StatusCode::NOT_NULL) {
            $detail = PaymentHistory::search($request->all());
            View::share([
                'allTotal' => $detail->sum('price'),
            ]);
            $detail = $detail->orderBy('id', 'desc')->paginate(20);
            View::share([
                'allTotalPage' => $detail->sum('price'),
            ]);

        } else {
            $request->merge([
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ]);
            $detail = PaymentHistory::search($request->all());

            View::share([
                'allTotal' => $detail->sum('price'),
            ]);
            $detail = $detail->paginate(20);
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
        $order = Order::with('customer', 'orderDetails', 'paymentHistories')->findOrFail($id);
        $now = Carbon::now()->format('d-m-Y');
        $order->now = $now;
        $data = $order->paymentHistories;
        return view('order.order', compact('order', 'data'));
    }

    public function destroy(Request $request, $id)
    {

        $order = $this->orderService->delete($id);

        $request->session()->flash('error', 'Xóa đơn hàng thành công!');
    }

    public function orderDetailPdf($id)
    {
        $order = Order::with('customer', 'orderDetails')->findOrFail($id);
        $pdf = \PDF::loadView('order.order-pdf', compact('order'));
        return $pdf->download('order.pdf');
    }

    public function payment(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $input = $request->except('customer_id');
            $paymentHistory = PaymentHistoryService::create($input, $id);
            $customer = Customer::find($request->customer_id);
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

            $check = PaymentHistory::where('order_id', $id)->get();
            $check2 = RuleOutput::where('event', 'add_order')->first();
            if (count($check) <= 1 && isset($check2) && $check2 && @$check2->rules->status == StatusCode::ON) {
                $check3 = PaymentHistory::where('order_id', $id)->first();
                $rule = $check2->rules;
                $config = @json_decode(json_decode($rule->configs))->nodeDataArray;
                $sms_ws = Functions::checkRuleSms($config);
                if (count($sms_ws)) {
                    foreach ($sms_ws as $sms) {
                        $input_raw['full_name'] = $check3->order->customer->full_name;
                        $input_raw['phone'] = @$check3->order->customer->phone;
                        $exactly_value = Functions::getExactlyTime($sms);
                        $text = $sms->configs->content;
                        $phone = Functions::convertPhone($input_raw['phone']);
                        $text = Functions::replaceTextForUser($input_raw, $text);
                        $text = Functions::vi_to_en($text);
                        $err = Functions::sendSmsV3($phone, @$text, $exactly_value);
                        if (isset($err) && $err) {
                            $input['phone'] = $phone;
                            $input['campaign_id'] = 0;
                            $input['message'] = $text;
                            HistorySms::create($input);
                        }
                    }
                }
                $jobs = Functions::checkRuleJob($config);
                if (count($jobs)) {
                    foreach ($jobs as $job) {
                        $day = $job->configs->delay_value;
                        $sms_content = $job->configs->sms_content;
                        $input = [
                            'customer_id' => @$check3->order->customer->id,
                            'date_from' => Carbon::now()->addDays($day)->format('Y-m-d'),
                            'time_from' => '07:00',
                            'date_to' => Carbon::now()->addDays($day)->format('Y-m-d'),
                            'time_to' => '16:00',
                            'code' => 'CV-CSKH',
                            'user_id' => @$check3->order->customer->telesales_id,
                            'all_day' => 'on',
                            'priority' => 1,
                            'amount_of_work' => 1,
                            'type' => 2,
                            'sms_content' => Functions::vi_to_en($sms_content),
                            'name' => 'Công việc chăm sóc khách hàng',
                            'description' => 'Bạn có công việc CSKH sau' . $day . 'ngày sử dụng dịch vụ: ' . @$check3->order->customer->full_name . '---' . @$check3->order->customer->phone,
                        ];
                        $this->taskService->create($input);
                    }
                }
            }
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
        if ($request->type_delete == StatusCode::TYPE_ORDER_PROCESS) {
            $order->update([
                'count_day' => $order->count_day - 1,
            ]);
        }

        HistoryUpdateOrder::create([
            'user_id' => $request->user_id,
            'order_id' => $order->id,
            'type' => $request->type_delete,
            'description' => $request->description,
        ]);

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
            $order->update([
                'count_day' => $order->count_day + 1,
            ]);
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
        $order = Order::with('historyUpdateOrders.user', 'customer', 'orderDetails.service')->find($id);

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

        $spaTherapissts = User::where('role', UserConstant::TECHNICIANS)->pluck('full_name', 'id');
        $title = 'Cập nhật đơn hàng';
        $customers = Customer::pluck('full_name', 'id');
        $customerId = $order->member_id;
        $customer = Customer::where('id', $customerId)->first();
        $services = Services::where('type', StatusCode::SERVICE)->with('category')->get();
        $products = Services::where('type', StatusCode::PRODUCT)->with('category')->get();
        $combo = Services::where('type', StatusCode::COMBOS)->with('category')->get();
        $role_type = $order->role_type;

        return view('order.index',
            compact('order', 'spaTherapissts', 'title', 'customers', 'customer', 'services', 'products', 'role_type', 'combo'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        if ($input['role_type'] == StatusCode::COMBOS) {
            $check = $this->orderService->find($id);
            $combo = Services::find($input['service_id'][0]);
            $date = strtotime('+' . $combo->hsd . ' months', strtotime($check->created_at));
            $date = date("Y-m-d", $date);
            $input['hsd'] = $date;
        }
        $customer = Customer::find($request->user_id);
        $customer->update($request->only('full_name', 'phone', 'address', 'status_id'));

        DB::beginTransaction();
        try {
            $order = $this->orderService->update($id, $input);

            if (!$order) {
                DB::rollBack();
            }

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
                    $customer = Customer::where('phone', $row['so_dt'])->first();
                    $service = Services::where('name', $row['ten_san_pham'])->first();
                    $checkOrder = Order::where('code', $row['ma_dh'])->first();
                    $paymentType = null;

                    if ($row['hinh_thuc_thanh_toan_tung_lan'] == null) {
                        $paymentType = null;
                    } elseif ($row['hinh_thuc_thanh_toan_tung_lan'] == "Tiền mặt") {
                        $paymentType = 1;
                    } else {
                        $paymentType = 2;
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
                                'count_day' => 0,
                                'the_rest' => (int)$row['con_lai'],
                                'description' => $row['mo_ta'],
                                'gross_revenue' => $row['da_thanh_toan'],
                                'payment_type' => $paymentType,
                                'payment_date' => $payment_date,
                                'type' => Order::TYPE_ORDER_DEFAULT,
                                'spa_therapisst_id' => '',
                                'created_at' => Carbon::createFromFormat('d/m/Y',
                                    $row['ngay_tao'])->format('Y-m-d'),
                            ]);
                        } else {
                            $order = isset($checkOrder) ? $checkOrder : 0;
                        }

                        if (!empty($customer)) {
                            $orderDetail = OrderDetail::create([
                                'order_id' => $order->id,
                                'code' => $row['ma_sp'],
                                'booking_id' => $service->id,
                                'quantity' => $row['so_luong'],
                                'total_price' => $row['gia_ban'],
                                'user_id' => $customer ? $customer->id : $order->member_id,
                                'address' => $customer ? $customer->address : '',
                                'vat' => $row['vat'],
                                'percent_discount' => $row['ck'],
                                'number_discount' => $row['ckd'],
                                'price' => $row['gia_ban'],
                            ]);

                            PaymentHistory::create([
                                'order_id' => $order->id,
                                'price' => $row['da_thanh_toan'],
                                'payment_date' => Carbon::now()->format('Y-m-d'),
                            ]);
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
            && !isset($request->order_type) && !isset($request->phone) && !isset($request->bor_none)) {
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
}
