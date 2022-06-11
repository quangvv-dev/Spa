<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\PromotionResource;
use App\Models\Order;
use App\Models\Promotion;
use Illuminate\Http\Request;

class VouchersController extends BaseApiController
{

    public function __construct()
    {
        //coding
    }

    /**
     * Danh sách lịch hẹn
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $customer = $request->jwtUser;
        $records = isset($request->records)?$request->records:StatusCode::PAGINATE_10;
        $promotions = Promotion::where('current_quantity', '>', 0)->where('group', 'like',
            '%"' . $customer->status_id . '"%')->paginate($records);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', PromotionResource::collection($promotions));
    }

    /**
     * Vouchers đã sử dụng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function used(Request $request)
    {
        $customer = $request->jwtUser;
        $records = isset($request->records)?$request->records:StatusCode::PAGINATE_10;
        $vouchers = Order::select('voucher_id')->where('member_id', $customer->id)->where('voucher_id', '>',
            0)->pluck('voucher_id')->toArray();
        $promotions = Promotion::whereIn('id', $vouchers)->withTrashed()->paginate($records);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', PromotionResource::collection($promotions));
    }

}
