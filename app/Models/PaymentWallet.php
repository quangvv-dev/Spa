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

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
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
        $detail = self::select($select)->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('payment_date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        })
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })
            ->when(isset($input['payment_type']) && $input['payment_type'], function ($q) use ($input) {
            $q->where('payment_type', $input['payment_type']);
        })
            ->when(isset($input['user_id']) && $input['user_id'], function ($q) use ($input) {
            $q->whereHas('order_wallet', function ($qr) use ($input) {
                $qr->where('user_id', $input['user_id']);
            });
        })->with('order_wallet')->has('order_wallet');

        return $detail;
    }
}
