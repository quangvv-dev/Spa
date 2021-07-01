<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\AppleResource;
use App\Models\Order;
use App\Models\Services;
use App\Services\OrderService;
use App\Services\OrderDetailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class AppleController extends BaseApiController
{
    private $orderService;
    private $orderDetailService;

    public function __construct(OrderService $orderService, OrderDetailService $orderDetailService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
    }

    public function services()
    {
        $services = Services::paginate(20);
        $data = AppleResource::collection($services);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function storeOrder(Request $request)
    {
        $user = User::find($request->jwtUser->id);
        $param = $request->all();
        $param['user_id'] = $user->id;
        $param['role_type'] = StatusCode::SERVICE;
        $param['branch_id'] = 1;
        $param['days'] = 0;
        $param['service_id'] = (array)json_decode($param['service_id']);
        $param['total_price'] = (array)json_decode($param['price']);
        $param['price'] = (array)json_decode($param['price']);
        $param['quantity'] = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];
        $param['vat'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $param['number_discount'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $param['service_note'] = null;
        $param['discount'] = 0;
        $param['days'] = [0, 0, 0, 0, 0];
        $param['address'] = null;
        $param['discount_order'] = 0;
        $param['count_day'] = 0;
        $param['voucher_id'] = 0;
        $param['created_at'] = Date::now()->format('d-m-Y');

        $order = $this->orderService->create($param);
        $orderDetail = $this->orderDetailService->create($param, $order->id);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $orderDetail);
    }

    public function listOrders(Request $request)
    {
        $user = User::find($request->jwtUser->id);
        $request->merge(['api_type' => 2]);
        $orders = Order::where('member_id', $user->id)->with('orderDetails')->has('orderDetails')->orderByDesc('id')->get();
        $data = AppleResource::collection($orders);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }
}
