<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
use App\Models\Customer;
use App\Models\HistoryUpdateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Services;
use App\Models\Status;
use App\Services\OrderDetailService;
use App\Services\OrderService;
use App\Services\PaymentHistoryService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use DB;
use Excel;
use Exception;
use Log;

class OrderController extends Controller
{
    private $orderService;
    private $orderDetailService;

    public function __construct(OrderService $orderService, OrderDetailService $orderDetailService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;

        $services = Services::orderBy('category_id', 'asc')->orderBy('id', 'desc')->get()->pluck('name',
            'id')->prepend('-Chọn sản phẩm-', '');
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id');
        $order_type = [
            Order::TYPE_ORDER_DEFAULT => 'Đơn thường',
            Order::TYPE_ORDER_ADVANCE => 'Liệu trình',
        ];
        view()->share([
            'services'   => $services,
            'status'     => $status,
            'order_type' => $order_type,
        ]);
    }

    public function index(Request $request)
    {
        $customerId = $request->customer_id;
        $customer = Customer::find($customerId);
        $spaTherapissts = User::where('role', UserConstant::TECHNICIANS)->pluck('full_name', 'id');
        $title = 'Tạo đơn hàng';
        $services = Services::with('category')->get();
        $customers = Customer::pluck('full_name', 'id');
        return view('order.index', compact('title', 'customers', 'customer', 'spaTherapissts', 'services'));
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
        $customer->update($request->only('full_name', 'phone', 'address', 'status_id'));

        DB::beginTransaction();
        try {

            $order = $this->orderService->create($param);

            if (!$order) DB::rollBack();

            if (isset($request->spa_therapisst_id)) {
                HistoryUpdateOrder::create([
                    'user_id'  => $request->spa_therapisst_id,
                    'order_id' => $order->id,
                ]);
            }

            $orderDetail = $this->orderDetailService->create($param, $order->id);

            if (!$orderDetail) DB::rollBack();

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

        if (count($request->all()) > 0) {
            $orders = Order::searchAll($request->all());

        } else {
            $now = Carbon::now()->format('m');
            $orders = Order::whereMonth('created_at', $now)->with('orderDetails');
            $orders = $orders->paginate(100);
        }

        if ($request->ajax()) {
            return Response::json(view('order-details.ajax', compact('orders', 'title'))->render());
        }

        return view('order-details.index',
            compact('orders', 'title', 'group', 'marketingUsers', 'telesales', 'source'));
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
            $input = $request->all();
            $paymentHistory = PaymentHistoryService::create($input, $id);

            $order = $this->orderService->updatePayment($input, $id);
            if (!$paymentHistory || !$order) {
                DB::rollBack();
            }

            DB::commit();
            $check = PaymentHistory::where('order_id', $id)->get();
            $check2 = PaymentHistory::where('order_id', $id)->first();
            if (count($check) == 1) {
                $body = setting('sms_cskh_booking');
                $body = str_replace('%full_name%', @$check2->order->customer->full_name, $body);
                $body = Functions::vi_to_en($body);
                $date = Carbon::now()->format('d/m/Y H:i');
                Functions::sendSms(@$check2->order->customer->phone, $body, $date);
            }
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
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
        $services = Services::handleChart();
        return view('report_products.chart', compact('title', 'services'));
    }

    public function updateCountDay(Request $request, $id)
    {
        $order = $this->orderService->find($id);

        if ($order->type === Order::TYPE_ORDER_ADVANCE && $order->count_day == 0) {
            return "Failed";
        }

        $order->update([
            'count_day' => $order->count_day - 1,
        ]);

        $historyUpdateOrder = HistoryUpdateOrder::create([
            'user_id'     => $request->user_id,
            'order_id'    => $order->id,
            'description' => $request->description,
        ]);

        return "Success";
    }

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
        $services = Services::with('category')->get();

        return view('order.index', compact('order', 'spaTherapissts', 'title', 'customers', 'customer', 'services'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $customer = Customer::find($request->user_id);
        $customer->update($request->only('full_name', 'phone', 'address', 'status_id'));

        DB::beginTransaction();
        try {
            $order = $this->orderService->update($id, $input);

            if (!$order) DB::rollBack();

            $orderDetail = $this->orderDetailService->update($input, $id);

            if (!$orderDetail) DB::rollBack();

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
                    $paymentType = NULL;

                    if ($row['hinh_thuc_thanh_toan_tung_lan'] == null) {
                        $paymentType = NULL;
                    } elseif ($row['hinh_thuc_thanh_toan_tung_lan'] == "Tiền mặt") {
                        $paymentType = 1;
                    } else {
                        $paymentType = 2;
                    }

                    if (!empty($service)) {
                        if (!empty($customer) && empty($checkOrder)) {
                            $order = Order::create([
                                'code' => $row['ma_dh'],
                                'member_id' => $customer->id,
                                'all_total' => $row['doanh_so'],
                                'count_day' => 0,
                                'the_rest' => $row['con_lai'],
                                'description' => $row['mo_ta'],
                                'gross_revenue' => $row['doanh_thu'],
                                'payment_type' => $paymentType,
                                'payment_date' => Carbon::createFromFormat('d/m/Y', substr($row['ngay_thanh_toan'], 0, 10))->format('Y-m-d'),
                                'type' => Order::TYPE_ORDER_DEFAULT,
                                'spa_therapisst_id' => '',
                                'created_at' => Carbon::createFromFormat('d/m/Y', $row['ngay_tao'])->format('Y-m-d'),
                            ]);
                        }

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
                    }

                }
            });

            return redirect()->back()->with('status', 'Tải đơn hàng thành công');
        }
    }

    public function checkUniqueCode(Request $request)
    {
        $order = Order::where('code',$request->code)->first();

        if ($order) return $order->id == $request->id ? 'true' : 'false';

        return 'true';
    }

    public function deletePayment($id)
    {
        $order = $this->orderService->deletePayment($id);

        return redirect('order/' . $order->id . '/show')->with('status', 'Xoá lịch sử thanh toán thành công');
    }

}
