<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;


use App\Models\Commission;
use App\Models\Order;

class CommissionService
{
    public $commission;

    public function __construct( Commission $commission)
    {
        $this->commission = $commission;
    }

    public function create(array $data, $orderId)
    {
        if (empty($data)) return false;

        $dataArr = [];

        foreach ($data['user_id'] as $key => $val) {
            $data['earn'][$key] = $this->calculate($data['percent'][$key], $orderId);

            $dataArr[] = [
                'user_id'  => $data['user_id'][$key],
                'percent'  => $data['percent'][$key],
                'note'     => $data['note'],
                'order_id' => $orderId,
                'earn'     => $data['earn'][$key]
            ];
        }

        $model = Commission::insert($dataArr);

        return $model;
    }

    public function calculate($percent, $orderId)
    {
        $order = Order::where('id', $orderId)->first();

        $money = ($percent / 100) * $order->all_total;

        return (int)$money;
    }
}
