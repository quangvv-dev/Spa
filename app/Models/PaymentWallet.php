<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentWallet extends Model
{
    protected $guarded = ['id'];

//    use SoftDeletes;

    public function order_wallet()
    {
        return $this->belongsTo(WalletHistory::class, 'order_wallet_id');
    }

    public function getNamePaymentTypeAttribute()
    {
        if ($this->payment_type === 1) {
            return "Tiền mặt";
        } elseif ($this->payment_type === 2) {
            return "Thẻ";
        } elseif ($this->payment_type === 4) {
            return "Chuyển khoản";
        }
    }

    public static function search($input, $select = '*')
    {

        if (isset($input['start_date']) && isset($input['end_date'])) {
            $detail = self::select($select)->whereBetween('payment_date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])->with('order_wallet');
        }

        if (!empty($input['branch_id'])) {
            $detail = $detail->where('branch_id', $input['branch_id']);
        }
        if (!empty($input['payment_type'])) {
            $detail = $detail->where('payment_type', $input['payment_type']);
        }
        if (isset($input['user_id'])) {
            $detail = $detail->whereHas('order_wallet', function ($qr) use ($input) {
                $qr->where('user_id', $input['user_id']);
            });
        }

        return $detail;
    }
}
