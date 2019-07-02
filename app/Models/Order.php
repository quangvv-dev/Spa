<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'member_id', 'id');
    }

    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class, 'order_id', 'id');
    }

    public static function search($input)
    {
        $data = self::with( 'orderDetails');

        if ($input) {
            $data = $data
            ->when($input['group'], function ($query) use ($input) {
                $query->whereHas('customer', function ($q) use ($input) {
                    $q->where('group_id', $input['group']);
                });
            })
            ->when($input['telesale'], function ($query) use ($input) {
                $query->whereHas('customer', function ($q) use ($input) {
                   $q->where('telesales_id', $input['telesale']);
                });
            })
            ->when($input['marketing'], function ($query) use ($input) {
                $query->whereHas('customer', function ($q) use ($input) {
                   $q->where('mkt_id', $input['marketing']);
                });
            })
            ->when($input['service'], function ($query) use ($input) {
                $query->whereHas('orderDetails', function ($q) use ($input) {
                   $q->where('booking_id', $input['service']);
                });
            })
            ->when($input['customer'], function ($query) use ($input) {
                $query->whereHas('customer', function ($q) use ($input) {
                   $q->where('full_name', 'like', '%'. $input['customer']. '%')
                   ->orWhere('phone', 'like', '%'. $input['customer']. '%');
                });
            })
            ->when($input['payment_type'], function ($query) use ($input) {
                $query->whereNotNull('payment_type')->where('payment_type', $input['payment_type']);
            });
        }

        return $data->paginate(10);
    }

    public function getNamePaymentTypeAttribute()
    {
        if ($this->payment_type === 1) {
            return "Tiền mặt";
        }

        if ($this->payment_type === 2) {
            return "Thẻ";
        }
    }
}
