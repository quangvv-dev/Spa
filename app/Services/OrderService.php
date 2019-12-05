<?php

namespace App\Services;

use App\Models\GroupComment;
use App\Models\Order;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function create($data)
    {
        $theRest = array_sum(replaceNumberFormat($data['total_price']));
        $countDay = 0;
        if (empty($data) && is_array($data) == false) {
            return false;
        }

        if (!empty($data['spa_therapisst_id']) && !empty($data['count_day'])) {
            $countDay = $data['count_day'] - 1;
        }

        $input = [
            'member_id'         => $data['user_id'],
            'the_rest'          => $theRest,
            'count_day'         => $countDay,
            'type'              => $data['count_day'] == null ? Order::TYPE_ORDER_DEFAULT : Order::TYPE_ORDER_ADVANCE,
            'all_total'         => $theRest,
            'spa_therapisst_id' => $data['spa_therapisst_id']
        ];

        $model = $this->order->fill($input);
        $model->save();

        return $model;

    }

    public function updatePayment($data, $id)
    {
        $model = $this->find($id);
        $data['gross_revenue'] = replaceNumberFormat($data['gross_revenue']);
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
        $data['gross_revenue'] = replaceNumberFormat($data['gross_revenue']);
        if (empty($data['gross_revenue']) && is_array($data) == false) {
            return false;
        }

        $model = $this->find($id);

        $order = [
            'cash'        => $data['gross_revenue'] ?: 0,
            'remain_cash' => $model->the_rest - $data['gross_revenue'],
            'return_cash' => $data['gross_revenue'] > $model->the_rest ? $data['gross_revenue'] - $model->the_rest : 0,
        ];

        if ($order['remain_cash'] < 0) {
            $order['remain_cash'] = 0;
        }

        return $order;
    }

    public function delete($id)
    {
        $order = $this->find($id);
        GroupComment::create([
            'customer_id' => $order->member_id,
            'user_id'     => Auth::user()->id,
            'messages'    => 'Tin hệ thống : ' . Auth::user()->full_name . ' đã xóa đơn hàng trị giá ' . $order->all_total,
        ]);
        return $order->delete();
    }

    public static function handleData($data)
    {
        $status = [];

        foreach ($data as $item) {
            $revenue = 0;
            if (isset($item->customerSources)) {
                foreach ($item->customerSources as $customer) {
                    $revenue += $customer->orders->sum('gross_revenue');
                }
                $status[$item->id]['revenue'] = $revenue;
                $status[$item->id]['name'] = $item->name;
            }
        }

        return $status;
    }

    public function orderDetail($id)
    {
        $order = Order::with('customer.telesale', 'orderDetails.service', 'spaTherapisst')->find($id);

        $orderDetails = [];
        foreach ($order->orderDetails as $orderDetail) {
            if ($orderDetail->service) {
                $orderDetails[] = $orderDetail;
            }
        }

        return $data = [
            'order' => $order,
            'order_details' => $orderDetails
        ];
    }

    public function update($id, $attibutes)
    {
        $order = $this->find($id);

        $theRest = array_sum($attibutes['total_price']);
        if (empty($attibutes) && is_array($attibutes) == false) {
            return false;
        }

        $attibutes = [
            'member_id'         => $attibutes['user_id'],
            'the_rest'          => $theRest,
            'count_day'         => $attibutes['count_day'],
            'type'              => $attibutes['count_day'] == null ? Order::TYPE_ORDER_DEFAULT : Order::TYPE_ORDER_ADVANCE,
            'all_total'         => array_sum($attibutes['total_price']),
            'spa_therapisst_id' => $attibutes['spa_therapisst_id']
        ];

        $model = $order->update($attibutes);

        return $model;

    }
}
