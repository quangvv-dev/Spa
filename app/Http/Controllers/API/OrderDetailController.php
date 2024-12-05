<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;


class OrderDetailController extends BaseApiController
{
    /**
     * Login APP
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
}
