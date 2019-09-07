<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Category;
use App\Models\Customer;
use App\Models\HistoryUpdateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Services;
use App\Models\Status;
use App\Services\OrderDetailService;
use App\Services\OrderService;
use App\Services\PaymentHistoryService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use DB;

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

    public function index()
    {
        $title = 'Tạo đơn hàng';
        $customers = Customer::pluck('full_name', 'id');
        return view('order.index', compact('title', 'customers'));
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

        $order = $this->orderService->create($param);
        $this->orderDetailService->create($param, $order->id);

        return redirect('/order/' . $order->id . '/show')->with('status', 'Tạo đơn hàng thành công');
    }

    public function listOrder(Request $request)
    {
        $title = 'ĐƠN HÀNG BÁN';
        $group = Category::pluck('name', 'id')->toArray();
        $marketingUsers = User::pluck('full_name', 'id')->toArray();
        $telesales = User::where('role', UserConstant::TELESALES)->pluck('full_name', 'id')->toArray();
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $orders = Order::search($request->all());

        if ($request->ajax()) {
            return Response::json(view('order-details.ajax', compact('orders', 'title'))->render());
        }

        return view('order-details.index',
            compact('orders', 'title', 'group', 'marketingUsers', 'telesales', 'source'));
    }

    public function show($id)
    {
        $order = Order::with('customer', 'orderDetails', 'paymentHistories')->findOrFail($id);
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
            $paymentHistory = PaymentHistoryService::create($request->all(), $id);
            $order = $this->orderService->updatePayment($request->all(), $id);

            if (!$paymentHistory || !$order) {
                DB::rollBack();
            }

            DB::commit();
            return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
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
            'user_id' => Auth::user()->id,
            'order_id' => $order->id
        ]);

        return "Success";
    }

    public function getOrderById(Request $request, $id)
    {
        $order = Order::with('historyUpdateOrders.user')->find($id);

        return Response::json($order);
    }

}
