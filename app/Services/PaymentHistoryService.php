<?php

namespace App\Services;

use App\Helpers\Functions;
use App\Models\Order;
use App\Models\PaymentHistory;

class PaymentHistoryService
{
    public $paymentHistory;

    public function __construct(PaymentHistory $paymentHistory)
    {
        $this->paymentHistory = $paymentHistory;
    }

    public static function create($data, $id)
    {
        $data['gross_revenue'] = str_replace(',', '', $data['gross_revenue']);
        $grossRevenue = self::checkGrossRevenue($id, $data['gross_revenue']);

        if (empty($data) && is_array($data) == false) {
            return false;
        }

        $input = [
            'order_id'     => $id,
            'branch_id'    => $data['branch_id'],
            'price'        => $grossRevenue,
            'payment_date' => Functions::yearMonthDay($data['payment_date']),
            'description'  => $data['description'],
            'payment_type' => $data['payment_type'],
            'is_debt'      => $data['is_debt'],
        ];

        return PaymentHistory::create($input);

    }

    private static function checkGrossRevenue($id, $grossRevenue)
    {
        $order = Order::where('id', $id)->first();
        $price = $order->paymentHistories->sum('price');
        $total = $price + $grossRevenue;
        if ($total > $order->all_total) {
            $grossRevenue = $order->all_total - $price;

            return $grossRevenue;
        }

        return $grossRevenue;
    }
}
