<?php

namespace App\Http\Controllers\API;

use App\Constants\OrderConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\ProductDepotResource;
use App\Models\HistoryDepot;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDepot;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Helpers\Functions;

class DepotController extends BaseApiController
{
    public function productDepot()
    {
        $product = Services::select('id', 'name')->where('type', StatusCode::PRODUCT)->get();
        $new = (object) [
            'id'=>0,
            'name'=>'Tất cả sản phẩm'
        ];
        $product->push($new);
//        $collection->put(0,'Tât cả');
//        dd($collection);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $product);

    }

    /**
     * Update Post
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDate($request);
        }
        $input = $request->all();

        $docs = ProductDepot::select('branch_id', 'product_id', 'quantity')
            ->when(isset($input['product_id']) && $input['product_id']>0, function ($q) use ($input) {
                $q->where('product_id', $input['product_id']);
            })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->get()->map(function ($item) use ($input) {
                $item->xuat_ban = OrderDetail::select('quantity')->where('booking_id', $item->product_id)
                    ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                        $q->where('branch_id', $input['branch_id']);
                    })->whereBetween('created_at', [
                        Functions::createYearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::createYearMonthDay($input['end_date']) . " 23:59",
                    ])->sum('quantity');
                $item->tieu_hao = HistoryDepot::select('quantity')->where('product_id', $item->product_id)
                    ->whereIn('status', [OrderConstant::TIEU_HAO, OrderConstant::HONG_VO, OrderConstant::XUAT_KHO])
                    ->whereBetween('created_at', [
                        Functions::createYearMonthDay($input['start_date']),
                        Functions::createYearMonthDay($input['end_date']),
                    ])->sum('quantity');
                return $item;
            })->sortByDesc('xuat_ban');

        $docs = ProductDepotResource::collection($docs);
//        $docs = [[
//            'branch' => 'Chi nhánh Q10',
//            'product' => 'Viên uống chống nắng BIO',
//            'quantity' => 1022,
//            'sell' => 100,
//            'failed' => 22,
//        ]];

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);
    }

}
