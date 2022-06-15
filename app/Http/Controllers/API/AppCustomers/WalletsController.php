<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\PromotionResource;
use App\Models\HistoryWalletCtv;
use App\Models\Order;
use App\Models\Promotion;
use Illuminate\Http\Request;

class WalletsController extends BaseApiController
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
        $records = isset($request->records) ? $request->records : StatusCode::PAGINATE_10;
        $history = HistoryWalletCtv::select('id', 'customer_id', 'price', 'type', 'created_at')
            ->where('customer_id',$customer->id)->orderByDesc('id')->paginate($records);
        $data = [
            'data' => $history->transform(function ($item) {
                return [
                    'id'            => $item->id,
                    'customer_id'   => $item->customer_id,
                    'price'         => $item->price,
                    'type'          => $item->type,
                    'created_at'    => date('d-m-Y H:s',strtotime($item->created_at)),
                ];
            })->toArray(),
            'currentPage' => $history->currentPage(),
            'lastPage'    => $history->lastPage(),
        ];

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
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
        $records = isset($request->records) ? $request->records : StatusCode::PAGINATE_10;
        $vouchers = Order::select('voucher_id')->where('member_id', $customer->id)->where('voucher_id', '>',
            0)->pluck('voucher_id')->toArray();
        $promotions = Promotion::whereIn('id', $vouchers)->withTrashed()->paginate($records);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', PromotionResource::collection($promotions));
    }

}
