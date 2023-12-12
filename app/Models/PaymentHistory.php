<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class PaymentHistory extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    public const MONEY = 1;
    public const CARD = 2;
    public const POINT = 3; // điểm
    public const TRANSFER = 4;//Chuyển khoản
    public const TRA_GOP = 5;

    public const label = [
        self::MONEY => 'Tiền mặt',
        self::CARD => 'Thẻ',
        self::POINT => 'Điểm',
        self::TRANSFER => 'Chuyển khoản',
        self::TRA_GOP => 'Trả góp',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Attribute
     * @return string
     */
    public function getNamePaymentTypeAttribute()
    {
        if ($this->payment_type === self::MONEY) {
            return "Tiền mặt";
        } elseif ($this->payment_type === self::CARD) {
            return "Thẻ";
        } elseif ($this->payment_type === self::POINT) {
            return "Điểm";
        } elseif ($this->payment_type === self::TRANSFER) {
            return "Chuyển khoản";
        } else {
            return "Trả góp";
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
        if (isset($input['group_branch']) && count($input['group_branch'])) {
            $detail = $detail->whereIn('branch_id', $input['group_branch']);
        }
        if (!empty($input['branch_id'])) {
            $detail = $detail->where('branch_id', $input['branch_id']);
        }
        if (!empty($input['payment_type'])) {
            $detail = $detail->where('payment_type', $input['payment_type']);
        }
        if (!empty($input['marketing'])) {
            $detail = $detail->whereHas('order', function ($item) use ($input) {
                $item->whereHas('customer', function ($q) use ($input) {
                    $q->where('mkt_id', $input['marketing']);
                });
            });
        }
        if (!empty($input['carepage_id'])) {
            $detail = $detail->whereHas('order', function ($item) use ($input) {
                $item->where('carepage_id', $input['carepage_id']);
            });
        }
        if (!empty($input['source_id'])) {
            $detail = $detail->whereHas('order', function ($qr) use ($input) {
                $qr->where('source_id', $input['source_id']);
            });
        }
        if (isset($input['is_upsale'])) {
            $detail = $detail->whereHas('order', function ($qr) use ($input) {
                $qr->where('is_upsale', $input['is_upsale']);
            });
        }
        if (!empty($input['cskh_id'])) {
            $detail = $detail->whereHas('order', function ($item) use ($input) {
                $item->where('cskh_id', $input['cskh_id']);
            });
        }
        if (!empty($input['arr_marketing'])) {
            $detail = $detail->whereHas('order', function ($item) use ($input) {
                $item->whereHas('customer', function ($q) use ($input) {
                    $q->whereIn('mkt_id', $input['arr_marketing']);
                });
            });
        }
        if (!empty($input['carepage_id'])) {
            $detail = $detail->whereHas('order', function ($item) use ($input) {
                $item->whereHas('customer', function ($q) use ($input) {
                    $q->where('carepage_id', $input['carepage_id']);
                });
            });
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

//    public function getOrderMonthAttribute()
//    {
//        $order = Order::select('all_total')
//            ->whereBetween('created_at', [$this->payment_date . " 00:00:00",$this->payment_date . " 23:59:59"])
//            ->where('branch_id', $this->branch_id)->sum('all_total');
//        return $order;
//    }

//    public function getWalletMonthAttribute(Request $request)
//    {
//        $order = WalletHistory::select('order_price')
//            ->whereBetween('created_at', [$this->payment_date . " 00:00:00",$this->payment_date . " 23:59:59"])
//            ->where('branch_id', $this->branch_id)->sum('order_price');
//        return $order;
//    }
//
//    public function getPaymentWalletMonthAttribute()
//    {
//        $order = PaymentWallet::select('price')
//            ->whereBetween('payment_date', [$this->payment_date . " 00:00:00",$this->payment_date . " 23:59:59"])
//            ->where('branch_id', $this->branch_id)->sum('price');
//        return $order;
//    }
}
