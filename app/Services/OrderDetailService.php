<?php

namespace App\Services;

use App\Models\OrderDetail;
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
                'created_at'      => Carbon::now()->format('Y-m-d H:i'),
                'order_id'        => $orderId,
                'user_id'         => $data['user_id'],
                'booking_id'      => $data['service_id'][$key],
                'days'            => isset($data['days']) && count($data['days'])? $data['days'][$key]:0,
                'quantity'        => $data['quantity'][$key],
                'price'           => replaceNumberFormat($data['price'][$key]),
                'vat'             => $data['vat'][$key],
                'address'         => $data['address'],
                'number_discount' => replaceNumberFormat($data['number_discount'][$key]),
                'total_price'     => replaceNumberFormat($data['total_price'][$key]),
            ];
            $service = Services::where('id', $data['service_id'][$key])->first();

            $service->update(['description' => $data['service_note'][$key]]);
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
            $dataArr[] = [
                'id'              => isset($data['order_detail_id'][$key]) ? $data['order_detail_id'][$key] : '',
                'order_id'        => $orderId,
                'user_id'         => $data['user_id'],
                'booking_id'      => $data['service_id'][$key],
                'quantity'        => $data['quantity'][$key],
                'price'           => replaceNumberFormat($data['price'][$key]),
                'vat'             => $data['vat'][$key],
                'address'         => $data['address'],
                'number_discount' => replaceNumberFormat($data['number_discount'][$key]),
                'total_price'     => replaceNumberFormat($data['total_price'][$key]),
                'updated_at'      => Carbon::now()->format('Y-m-d H:i:s'),
            ];
            $service = Services::where('id', $data['service_id'][$key])->first();

            $service->update(['description' => $data['service_note'][$key]]);
        }
        OrderDetail::whereNotIn('id', $data['order_detail_id'])->where('order_id', $orderId)->delete();
        foreach ($dataArr as $item) {
            if (!empty($item['id'])) {
                $orderDetail = OrderDetail::where('id', $item['id'])->first();
                $orderDetail->update($item);
            }
            if (empty($item['id'])) {
                $orderDetail = OrderDetail::create($item);
            }
        }


        return $orderDetail;
    }
}
