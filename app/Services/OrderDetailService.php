<?php
namespace App\Services;

use App\Models\OrderDetail;

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

        if (empty($data) && is_array($data) == false)
            return false;

        foreach ($data['service_id'] as $key => $value) {
            $dataArr[] = [
                'order_id'         => $orderId,
                'user_id'          => $data['user_id'],
                'booking_id'       => $data['service_id'][$key],
                'quantity'         => $data['quantity'][$key],
                'price'            => $data['price'][$key],
                'vat'              => $data['vat'][$key],
                'address'          => $data['address'],
                'number_discount'  => $data['number_discount'][$key],
                'total_price'      => $data['total_price'][$key],
            ];
        }

        if (!empty($dataArr)) {
            $model = OrderDetail::insert($dataArr);

            return $model;
        }
    }

    public function update($data, $orderId)
    {
        if (empty($data) && is_array($data) == false)
            return false;
        $dataArr = [];

        foreach ($data['service_id'] as $key => $value) {
            $dataArr[] = [
                'id'               => isset($data['order_detail_id'][$key]) ? $data['order_detail_id'][$key]: '',
                'order_id'         => $orderId,
                'user_id'          => $data['user_id'],
                'booking_id'       => $data['service_id'][$key],
                'quantity'         => $data['quantity'][$key],
                'price'            => $data['price'][$key],
                'vat'              => $data['vat'][$key],
                'address'          => $data['address'],
                'number_discount'  => $data['number_discount'][$key],
                'total_price'      => $data['total_price'][$key],
            ];
        }

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
