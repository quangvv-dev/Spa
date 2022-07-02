<?php

namespace App\Services;

use App\Constants\StatusCode;
use App\Models\OrderDetail;
use App\Models\ProductDepot;
use App\Models\Services;
use Carbon\Carbon;

class OrderDetailService
{
    public $orderDetail;

    public function __construct(OrderDetail $orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    public function create($data, $orderId)
    {
        $dataArr = [];

        if (empty($data) && is_array($data) == false) {
            return false;
        }

        foreach ($data['service_id'] as $key => $value) {
            $dataArr[] = [
                'created_at' => Carbon::now()->format('Y-m-d H:i'),
                'order_id' => $orderId,
                'user_id' => $data['user_id'],
                'booking_id' => $data['service_id'][$key],
                'days' => isset($data['days']) && count($data['days']) ? $data['days'][$key] : 0,
                'quantity' => $data['quantity'][$key],
                'price' => replaceNumberFormat($data['price'][$key]),
                'vat' => 0,
                'address' => $data['address'],
                'number_discount' => replaceNumberFormat($data['number_discount'][$key]),
                'total_price' => replaceNumberFormat($data['total_price'][$key]),
                'branch_id' => $data['branch_id'],
            ];
            $service = Services::where('id', $data['service_id'][$key])->first();

            $service->update(['description' => $data['service_note'][$key]]);

            if ($data['role_type'] == StatusCode::PRODUCT || $data['role_type'] == StatusCode::COMBOS) {
                $product = ProductDepot::where('branch_id', $data['branch_id'])->where('product_id', $data['service_id'][$key])->first();
                if (isset($product)) {
                    $product->quantity = $product->quantity - $data['quantity'][$key];
                    $product->save();
                }
            }
        }
        if (!empty($dataArr)) {
            $model = OrderDetail::insert($dataArr);

            return $model;
        }
    }

    public function update($data, $orderId)
    {
        if (empty($data) && is_array($data) == false) {
            return false;
        }
        $dataArr = [];
        foreach ($data['service_id'] as $key => $value) {
            if ($data['service_id']){
                $dataArr[] = [
                    'id'            => isset($data['order_detail_id'][$key]) ? $data['order_detail_id'][$key] : '',
                    'order_id'      => $orderId,
                    'user_id'       => $data['user_id'],
                    'booking_id'    => $data['service_id'][$key],
                    'days'          => isset($data['days'][$key]) ?$data['days'][$key]:0,
                    'quantity'      => isset($data['quantity'][$key]) ? $data['quantity'][$key] : 0,
                    'price'         => replaceNumberFormat($data['price'][$key]),
                    'vat'           => 0,
                    'address'       => $data['address'],
                    'number_discount' => replaceNumberFormat($data['number_discount'][$key]),
                    'total_price'   => replaceNumberFormat($data['total_price'][$key]),
                    'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                ];
                $service = Services::where('id', $data['service_id'][$key])->withTrashed()->first();

                if (isset($data['service_note'][$key])) {
                    $service->update(['description' => $data['service_note'][$key]]);

                }
            }

        }
        $orderDetail =[];
        if (count($dataArr)){
            OrderDetail::where('order_id', $orderId)->delete();
            foreach ($dataArr as $item) {
                if (!empty($item['id'])) {
                    $orderDetail = OrderDetail::where('id', $item['id'])->first();
                    $orderDetail->update($item);
                }
                if (empty($item['id'])) {
                    $orderDetail = OrderDetail::create($item);
                }
            }
        }


        return $orderDetail;
    }
}
