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
                'percent_discount' => $data['percent_discount'][$key],
                'number_discount'  => $data['number_discount'][$key],
                'total_price'      => $data['total_price'][$key],
            ];
        }

        if (!empty($dataArr)) {
            $model = OrderDetail::insert($dataArr);

            return $model;
        }
    }
}
