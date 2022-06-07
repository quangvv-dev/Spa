<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\PromotionResource;
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
        $promotions = Promotion::where('group','like','"'.$customer->status_id.'"')->get();

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', PromotionResource::collection($promotions));
    }
}
