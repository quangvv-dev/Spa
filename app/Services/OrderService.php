<?php
namespace App\Services;

use App\Models\Order;
use App\Helpers\Functions;

class OrderService
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function create($data)
    {
        $theRest = array_sum($data['total_price']);
        if (empty($data) && is_array($data) == false)
            return false;

        $input = [
            'member_id'     => $data['user_id'],
            'the_rest'      => $theRest,
            'count_day'     => array_sum($data['count_day']),
            'all_total'     => array_sum($data['total_price'])
        ];

        $model = $this->order->fill($input);
        $model->save();

        return $model;

    }

    public function updatePayment($data, $id)
    {
        $model = $this->find($id);
        $data['gross_revenue'] = $model->gross_revenue + $data['gross_revenue'];
        $data['payment_date'] = Functions::yearMonthDay($data['payment_date']);
        $data['the_rest'] = $model->all_total - $data['gross_revenue'];

        if ($data['the_rest'] < 0) {
            $data['the_rest'] = 0;
        }

        if ($data['gross_revenue'] > $model->all_total) {
            $data['gross_revenue'] = $model->all_total;
        }

        $model->update($data);

        $model->gross_revenue = number_format($model->gross_revenue);
        $model->all_total = number_format($model->all_total);
        $model->payment_histories = $model->paymentHistories;

        return $model;
    }

    public function find($id)
    {
        $data = $this->order->where('id', $id)->first();

        return $data;
    }

    public function getPayment($data, $id)
    {
        if (empty($data['gross_revenue']) && is_array($data) == false)
            return false;

        $model = $this->find($id);

        $order = [
            'cash'        => $data['gross_revenue'] ?: 0,
            'remain_cash' => $model->the_rest - $data['gross_revenue'],
            'return_cash' => $data['gross_revenue'] > $model->the_rest ? $data['gross_revenue'] - $model->the_rest: 0
        ];

        if ($order['remain_cash'] < 0)
            $order['remain_cash'] = 0;

        return $order;
    }
}
