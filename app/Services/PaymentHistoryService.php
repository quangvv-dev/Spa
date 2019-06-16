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
        $order = Order::where('id', $id)->first();

        if ($data['gross_revenue'] > $order->all_total) {
            $data['gross_revenue'] = $order->all_total;
        }

        if (empty($data) && is_array($data) == false)
            return false;

        $input = [
            'order_id'     => $id,
            'price'        => $data['gross_revenue'],
            'payment_date' => Functions::yearMonthDay($data['payment_date']),
            'description'  => $data['description']
        ];

        PaymentHistory::create($input);

    }
}
