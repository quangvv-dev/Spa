<?php
namespace App\Services;

use App\Models\Order;

class OrderService
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function create($data)
    {
        $theRest = array_sum($data['total_price']) - $data['gross_revenue'];
        if (empty($data) && is_array($data) == false)
            return false;

        $input = [
            'member_id'     => $data['user_id'],
            'the_rest'      => $theRest,
            'count_day'     => array_sum($data['count_day']),
            'all_total'     => array_sum($data['total_price']),
            'gross_revenue' => $data['gross_revenue']
        ];

        $model = $this->order->fill($input);
        $model->save();

        return $model;

    }
}
