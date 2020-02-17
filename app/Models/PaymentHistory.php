<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentHistory extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public static function search($input)
    {
        if (isset($input['start_date']) && isset($input['end_date'])) {
            $detail = PaymentHistory::whereBetween('payment_date', [
                Functions::yearMonthDay($input['start_date']),
                Functions::yearMonthDay($input['end_date']),
            ])->with('order')->has('order');
        }

        if (isset($input['data_time'])) {
            if ($input['data_time'] == 'THIS_WEEK' ||
                $input['data_time'] == 'LAST_WEEK' ||
                $input['data_time'] == 'THIS_MONTH' ||
                $input['data_time'] == 'LAST_MONTH') {
                $detail = PaymentHistory::whereBetween('payment_date', getTime(($input['data_time'])))
                    ->with('order')->has('order');
            } elseif ($input['data_time'] == 'YESTERDAY' || $input['data_time'] == 'TODAY') {
                $detail = PaymentHistory::where('payment_date', getTime(($input['data_time'])))
                    ->with('order')->has('order');
            }
        }
        if (empty($input['start_date']) && empty($input['end_date']) && empty($input['data_time'])) {
            $detail = PaymentHistory::whereDate('payment_date', '=', date('Y-m-d'))
                ->with('order')->has('order');
        }

        return $detail;
    }
}
