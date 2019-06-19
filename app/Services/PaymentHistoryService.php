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
//        $order = Order::where('id', $id)->first();
//        $price = $order->paymentHistories->sum('price');
//
//        if ($data['gross_revenue'] > $order->all_total) {
//            $data['gross_revenue'] = $order->all_total;
//        }
        $grossRevenue = self::checkGrossRevenue($id, $data['gross_revenue']);

        if (empty($data) && is_array($data) == false)
            return false;

        $input = [
            'order_id'     => $id,
            'price'        => $grossRevenue,
            'payment_date' => Functions::yearMonthDay($data['payment_date']),
            'description'  => $data['description']
        ];

        PaymentHistory::create($input);

    }

    private function checkGrossRevenue($id, $grossRevenue)
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
