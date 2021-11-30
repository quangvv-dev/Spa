<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use Illuminate\Http\Request;
use App\Constants\PromotionConstant;
use App\Models\Promotion;

class PromotionController extends BaseApiController
{

    /**
     * Danh sach voucher
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listVoucherServices(Request $request)
    {
        $data = Promotion::where('service_id', '<>', 0)->where('service_id', $request->service)->where('current_quantity', '>', 0)->where('group', 'like', '%"' . $request->status . '"%')->get();
        return $this->responseApi(ResponseStatusCode::OK, 'success', $data);
    }

    /**
     * Danh sach voucher
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listVoucher(Request $request)
    {
        $data = Promotion::where('service_id', 0)->where('current_quantity', '>', 0)->where('group', 'like', '%"' . $request->status . '"%')->get();
        return $this->responseApi(ResponseStatusCode::OK, 'success', $data);
    }

    /**
     * CHECK VOUCHER KHUYẾN MẠI
     *
     * @param Request $request
     * @param Promotion $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkVoucher(Request $request, $id)
    {
        $total_price = $request->total_price ?: 0;
        $promotion = Promotion::findOrFail($id);
        if ($promotion->type == PromotionConstant::MONEY) {//check trường hợp voucher tiền
            if ($total_price >= $promotion->min_price) {
                $data = [
                    'voucher_id' => $promotion->id,
                    'discount' => $promotion->money_promotion,
                ];
                return $this->responseApi(ResponseStatusCode::OK, 'success', $data);
            } else {//TIỀN TỔNG TIỀN NHỎ HƠN
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'total_price < min price_promotion');
            }
        }
        if ($promotion->type == PromotionConstant::PERCENT) {//check trường hợp voucher phần trăm
//            if ($total_price >= $promotion->min_price) {
            $check = (int)($total_price / 100) * (int)$promotion->percent_promotion;
            if ($check >= $promotion->max_discount) {
                $discount = $promotion->max_discount;
            } else {
                $discount = $check;
            }
            if ($discount > $total_price) {
                $discount = $total_price;
            }

            $data = [
                'voucher_id' => $promotion->id,
                'discount' => $discount,
            ];

            return $this->responseApi(ResponseStatusCode::OK, 'success', $data);
//            }
//            else {
//                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'total_price < min price_promotion');
//            }
        }
    }
}
