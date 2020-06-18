<?php

namespace App\Services;

use App\Models\GroupComment;
use App\Models\Order;
use App\Helpers\Functions;
use App\Models\PaymentHistory;
use Carbon\Carbon;
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

        $now = Carbon::now()->format('H:i:s');

        if (!empty($data['spa_therapisst_id']) && !empty($data['count_day'])) {
            $countDay = $data['count_day'] - 1;
        }
        $input = [
            'member_id'         => $data['user_id'],
            'the_rest'          => $theRest,
            'role_type'         => $data['role_type'],
            'hsd'               => isset($data['hsd'])?$data['hsd']:null,
            'count_day'         => $countDay,
            'type'              => ($data['count_day'] == null || $data['count_day'] == 0) ? Order::TYPE_ORDER_DEFAULT : Order::TYPE_ORDER_ADVANCE,
            'all_total'         => $theRest,
            'spa_therapisst_id' => isset($data['spa_therapisst_id']) ? $data['spa_therapisst_id'] : "",
            'created_at'        => isset($data['created_at']) ? Functions::yearMonthDay($data['created_at']) . $now : Carbon::now(),
        ];
        $model = $this->order->fill($input);
        $model->save();
        $model->code = $model->id < 10 ? 'DH0' . $model->id : 'DH' . $model->id;
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
                    if (count($customer->order_detail)){
                            $revenue += $customer->order_detail->sum('total_price');
                    }
                }
                if ($revenue >0){
                    $status[$item->id]['revenue'] = $revenue;
                    $status[$item->id]['name'] = @$item->name;
                }
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
            'order'         => $order,
            'order_details' => $orderDetails,
        ];
    }

    public function update($id, $attibutes)
    {
        $order = $this->find($id);

        $theRest = array_sum(replaceNumberFormat($attibutes['total_price'])) - $order->gross_revenue;
        $now = Carbon::now()->format('H:i:s');

        if (empty($attibutes) && is_array($attibutes) == false) {
            return false;
        }

        $attibutes = [
            'member_id'         => $attibutes['user_id'],
            'the_rest'          => $theRest,
            'role_type'         => $attibutes['role_type'],
            'hsd'               => isset($attibutes['hsd'])?$attibutes['hsd']:null,
            'count_day'         => $attibutes['count_day'],
            'type'              => ($attibutes['count_day'] == null || $attibutes['count_day'] == 0) ? Order::TYPE_ORDER_DEFAULT : Order::TYPE_ORDER_ADVANCE,
            'all_total'         => array_sum(replaceNumberFormat($attibutes['total_price'])),
            'spa_therapisst_id' => $attibutes['spa_therapisst_id'],
            'created_at'        => isset($attibutes['created_at']) ? Functions::yearMonthDay($attibutes['created_at']) . $now : Carbon::now(),
        ];

        $order->update($attibutes);

        return $order;

    }

    public function deletePayment($id)
    {
        $paymentHistory = PaymentHistory::where('id', $id)->first();

        $order = $this->find($paymentHistory->order_id);

        $order->update([
            'gross_revenue' => $order->gross_revenue - $paymentHistory->price,
            'the_rest'      => $order->the_rest + $paymentHistory->price,
        ]);

        $paymentHistory->delete();

        return $order;
    }
}
