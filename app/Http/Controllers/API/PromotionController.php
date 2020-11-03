<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use Illuminate\Http\Request;
use App\Constants\PromotionConstant;
use App\Models\Promotion;

class PromotionController extends BaseApiController
{

    public function listVoucher(Request $request)
    {
        $data = Promotion::where('group', 'like', '%' . $request->status . '%')->get();
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
    public function checkVoucher(Request $request, Promotion $promotion)
    {
        $total_price = $request->total_price ?: 0;
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
            if ($total_price >= $promotion->min_price) {
                $check = (int)($total_price / 100) * (int)$promotion->percent_promotion;
                if ($check >= $promotion->max_discount) {
                    $discount = $promotion->max_discount;
                } else {
                    $discount = $check;
                }
                $data = [
                    'voucher_id' => $promotion->id,
                    'discount' => $discount,
                ];
                return $this->responseApi(ResponseStatusCode::OK, 'success', $data);
            } else {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'total_price < min price_promotion');
            }
        }
    }
}
