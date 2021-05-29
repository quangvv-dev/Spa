<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends BaseApiController
{
    /**
     * Danh sách đơn hàng
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $orders = Order::searchAll($input)->paginate(StatusCode::PAGINATE_20);
        $data['lastPage'] = $orders->lastPage();
        $data['records'] = OrderResource::collection($orders);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function show(Order $id)
    {
        $order = $id;
        $data['name_customer'] = @$order->customer->full_name ;
        $data['phone'] = @$order->customer->phone ;
        $order_detail = OrderDetail::where('order_id',$order->id)->get();
        $data['records'] = OrderDetailResource::collection($order_detail);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }
}
