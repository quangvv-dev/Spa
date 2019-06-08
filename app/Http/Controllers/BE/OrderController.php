<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Services;
use App\Services\OrderDetailService;
use App\Services\OrderService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $orderService;
    private $orderDetailService;

    public function __construct(OrderService $orderService, OrderDetailService $orderDetailService)
    {
        $this->orderService       = $orderService;
        $this->orderDetailService = $orderDetailService;

        $service = Services::orderBy('category_id', 'asc')->orderBy('id', 'desc')->get()->pluck('name',
            'id')->prepend('-Chọn-', '');
        view()->share([
            'service' => $service,
        ]);
    }

    public function index()
    {
        $title = 'Tạo đơn hàng';
        $customers = User::where('role', UserConstant::CUSTOMER)->pluck('full_name', 'id');
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
            $data = User::find($id);
            return $data;
        }
    }

    public function store(Request $request)
    {
        $customer = User::find($request->user_id);
        $param = $request->all();
        $customer->update($param);

        $order = $this->orderService->create($param);
        $this->orderDetailService->create($param, $order->id);

        return redirect('/list-orders')->with('status', 'Tạo đơn hàng thành công');
    }

    public function listOrder()
    {
        $title = 'Danh sách đơn hàng chi tiết';
        $orders = Order::with('user', 'orderDetails')->paginate(10);

        return view('order-details.index', compact('orders', 'title'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'orderDetails')->findOrFail($id);

        return view('order.order', compact('order'));
    }

    public function orderDetailPdf($id)
    {
        $order = Order::with('user', 'orderDetails')->findOrFail($id);
        $pdf = \PDF::loadView('order.order-pdf', compact('order'));
        return $pdf->download('order.pdf');
    }

}
