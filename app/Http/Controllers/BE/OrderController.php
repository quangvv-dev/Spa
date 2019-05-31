<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Services;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
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
        $customer->update($request->all());

        $order = new Order;
        $order->member_id = $request->user_id;
        $order->all_total = array_sum($request->total_price);
        $order->save();

//        dd(1);
        $orderDetail = new OrderDetail;
//        $orderDetail->order_id         = $order->id;
//        $orderDetail->user_id          = $request->user_id;
//        $orderDetail->booking_id       = $request->service_id;
//        $orderDetail->quantity         = $request->quantity;
//        $orderDetail->price            = $request->price;
//        $orderDetail->vat              = $request->vat;
//        $orderDetail->address          = $request->address;
//        $orderDetail->percent_discount = $request->percent_discount;
//        $orderDetail->number_discount  = $request->number_discount;
//        $orderDetail->total_price      = $request->total_price;

        foreach ($request->service_id as $key => $value) {
            $data = [
                'order_id' => $order->id,
                'user_id'  => $request->user_id,
                'booking_id' => $request->service_id[$key],
                'quantity' => $request->quantity[$key],
                'price' => $request->price[$key],
                'vat' => $request->vat[$key],
                'address' => $request->address,
                'percent_discount' => $request->percent_discount[$key],
                'number_discount' => $request->number_discount[$key],
                'total_price' => $request->total_price[$key],
            ];
            OrderDetail::create($data);
        }
////        $input = $request->except('full_name', 'phone', 'service_id');
//
//        $input['order_id'] = $order->id;
////        $serviceId =
//        $input['booking_id'] = $request->service_id;
//
//        $dataOrderDetail = OrderDetail::create($input);

        return redirect('/')->with('status', 'Tạo đơn hàng thành công');
    }

}
