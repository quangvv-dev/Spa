<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\CommissionEmployee;
use App\Models\GroupComment;
use App\Models\Order;
use App\Helpers\Functions;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Constants\StatusCode;
use App\Models\ProductDepot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public $order;


    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function create($data)
    {
        $theRest = array_sum(replaceNumberFormat($data['total_price'])) - $data['discount'] - $data['discount_order'];
        $countDay = 0;
        if (empty($data) && is_array($data) == false) {
            return false;
        }

        $now = Carbon::now()->format('H:i:s');

        if (!empty($data['count_day'])) {
            $countDay = $data['count_day'];
        }

        if (!empty($data['spa_therapisst_id']) && !empty($data['count_day'])) {
            $countDay = $data['count_day'] - 1;
        }
        $input = [
            'member_id'         => $data['user_id'],
            'branch_id'         => $data['branch_id'],
            'the_rest'          => $theRest,
            'discount_order'    => $data['discount_order'],
            'role_type'         => $data['role_type'],
            'hsd'               => isset($data['hsd']) ? $data['hsd'] : null,
            'support_id'        => isset($data['support_id']) ? $data['support_id'] : 0,
            'count_day'         => $countDay,
            'type'              => ($data['count_day'] == null || $data['count_day'] == 0) ? Order::TYPE_ORDER_DEFAULT : Order::TYPE_ORDER_ADVANCE,
            'all_total'         => $theRest,
            'owner_id'          => Auth::user()->id ? Auth::user()->id : 1,
            'carepage_id'       => $data['carepage_id'] ?: 0,
            'mkt_id'            => $data['mkt_id'] ?: 0,
            'telesale_id'       => $data['telesale_id'] ?: 0,
            'source_id'         => $data['source_id'] ?: 0,
            'discount'          => $data['discount'] ?: 0,
            'voucher_id'        => $data['voucher_id'] ?: 0,
            'spa_therapisst_id' => isset($data['spa_therapisst_id']) ? $data['spa_therapisst_id'] : 0,
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
            'status_id'   => @$order->customer->status_id ?? null,
            'messages'    => "<span class='bold text-blue'>Đơn hàng: </span> " . Auth::user()->full_name . ' đã xóa đơn hàng trị giá ' . number_format($order->all_total),
        ]);
        if ($order->role_type == StatusCode::PRODUCT) {
            $order_detail = OrderDetail::select('booking_id', 'quantity')->where('order_id', $order->id)
                ->where('branch_id', $order->branch_id)->get();
            foreach ($order_detail as $item) {
                $product = ProductDepot::where('branch_id', $order->branch_id)->where('product_id',
                    $item->booking_id)->first();
                if (isset($product)) {
                    $product->quantity = $product->quantity + $item->quantity;
                    $product->save();
                }
            }

        }

        return $order->delete();
    }

    public static function handleData($data)
    {
        $status = [];
        foreach ($data as $item) {
            $revenue = 0;
            if (isset($item->customerSources)) {
                foreach ($item->customerSources as $customer) {
                    if (count($customer->order_detail)) {
                        $revenue += $customer->order_detail->sum('total_price');
                    }
                }
                if ($revenue > 0) {
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
        $theRest = array_sum(replaceNumberFormat($attibutes['total_price'])) - $order->gross_revenue - $order->discount - $order->discount_order;
        $now = Carbon::now()->format('H:i:s');

        if (empty($attibutes) && is_array($attibutes) == false) {
            return false;
        }

        $attibutes = [
            'member_id'         => $attibutes['user_id'],
            'the_rest'          => $theRest,
            'role_type'         => $attibutes['role_type'],
            'hsd'               => isset($attibutes['hsd']) ? $attibutes['hsd'] : null,
            'support_id'        => isset($attibutes['support_id']) ? $attibutes['support_id'] : 0,
            'count_day'         => $attibutes['count_day'],
            'type'              => ($attibutes['count_day'] == null || $attibutes['count_day'] == 0) ? Order::TYPE_ORDER_DEFAULT : Order::TYPE_ORDER_ADVANCE,
            'all_total'         => array_sum(replaceNumberFormat($attibutes['total_price'])) - $order->discount - $order->discount_order,
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
        if ($paymentHistory->payment_type != PaymentHistory::POINT) {
            $point = $paymentHistory->price / StatusCode::EXCHANGE_POINT * StatusCode::EXCHANGE_MONEY;
            $point = ($order->customer->wallet - $point) > 0 ? $order->customer->wallet - $point : 0;
        } else {
            $point = $order->customer->wallet + $paymentHistory->price;
        }
        $paymentHistory->delete();
        CommissionEmployee::where('payment_id', $id)->delete();

        $order->customer->wallet = $point;
        $order->customer->save();

        return $order;
    }

    public function revenueGenderWithOrders($input)
    {
        return Order::when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('orders.created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        })->when(isset($input['branch_id']), function ($query) use ($input) {
            $query->where('orders.branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('orders.branch_id', $input['group_branch']);
        })->join('customers as c', 'c.id', 'orders.member_id')->select(
            DB::raw('SUM(gross_revenue) as all_total'),
            DB::raw("(CASE WHEN c.gender='0' THEN 'Nữ' ELSE 'Nam' END) as name"))
            ->groupBy('c.gender')->get();
    }

    public function revenueLocaleWithOrders($input)
    {
        return Order::when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('orders.created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        })->when(isset($input['branch_id']), function ($query) use ($input) {
            $query->where('orders.branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('orders.branch_id', $input['group_branch']);
        })->join('customers as c', 'c.id', 'orders.member_id')
            ->join('locales as lc', 'c.locale_id', 'lc.id')
            ->select('lc.name', DB::raw('SUM(gross_revenue) as total'))
            ->groupBy('c.locale_id')->orderByDesc('total')->take(5)->get();
    }
}
