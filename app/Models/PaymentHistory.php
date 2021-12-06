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

    public function getNamePaymentTypeAttribute()
    {
        if ($this->payment_type === 1) {
            return "Tiền mặt";
        } elseif ($this->payment_type === 2) {
            return "Thẻ";
        }elseif ($this->payment_type === 4) {
            return "Chuyển khoản";
        } else {
            return "Điểm";
        }
    }

    public static function search($input, $select = '*')
    {

        if (isset($input['start_date']) && isset($input['end_date'])) {
            $detail = PaymentHistory::select($select)->whereBetween('payment_date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])->with('order')->has('order');
        }
        if (isset($input['data_time'])) {
            if ($input['data_time'] == 'THIS_WEEK' ||
                $input['data_time'] == 'LAST_WEEK' ||
                $input['data_time'] == 'THIS_MONTH' ||
                $input['data_time'] == 'LAST_MONTH') {
                $detail = PaymentHistory::select($select)->whereBetween('payment_date', getTime(($input['data_time'])))
                    ->with('order')->has('order');
            } elseif ($input['data_time'] == 'YESTERDAY' || $input['data_time'] == 'TODAY') {
                $detail = PaymentHistory::select($select)->where('payment_date', getTime(($input['data_time'])))
                    ->with('order')->has('order');
            }
        }
        if (!isset($input['start_date']) && !isset($input['end_date']) && !isset($input['data_time'])) {
            $detail = PaymentHistory::select($select)->whereBetween('created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])->with('order')->has('order');
        }
        if (!empty($input['branch_id'])) {
            $detail = $detail->where('branch_id', $input['branch_id']);
        }
        if (!empty($input['payment_type'])) {
            $detail = $detail->where('payment_type', $input['payment_type']);
        }
        if (isset($input['telesales'])) {
            $detail = $detail->whereHas('order', function ($item) use ($input) {
                $item->whereHas('customer', function ($q) use ($input) {
                    $q->where('telesales_id', $input['telesales']);
                });
            });
        }

        return $detail;
    }
}
