<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

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
            ->when(isset($input['group']), function ($query) use ($input) {
                $query->whereHas('customer', function ($q) use ($input) {
                    $q->where('group_id', $input['group']);
                });
            })
            ->when(isset($input['telesales']), function ($query) use ($input) {
                $query->whereHas('customer', function ($q) use ($input) {
                   $q->where('telesales_id', $input['telesales']);
                });
            })
            ->when(isset($input['marketing']), function ($query) use ($input) {
                $query->whereHas('customer', function ($q) use ($input) {
                   $q->where('mkt_id', $input['marketing']);
                });
            })
            ->when(isset($input['service']), function ($query) use ($input) {
                $query->whereHas('orderDetails', function ($q) use ($input) {
                   $q->where('booking_id', $input['service']);
                });
            })
            ->when(isset($input['customer']), function ($query) use ($input) {
                $query->whereHas('customer', function ($q) use ($input) {
                   $q->where('full_name', 'like', '%'. $input['customer']. '%')
                   ->orWhere('phone', 'like', '%'. $input['customer']. '%');
                });
            })
            ->when(isset($input['payment_type']), function ($query) use ($input) {
                $query->whereNotNull('payment_type')->where('payment_type', $input['payment_type']);
            })
            ->when(isset($input['data_time']), function ($query) use ($input) {
                $query->when($input['data_time'] == 'TODAY' ||
                    $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                    $q->whereDate('created_at', getTime(($input['data_time'])));
                })
                ->when($input['data_time'] == 'THIS_WEEK' ||
                    $input['data_time'] == 'LAST_WEEK' ||
                    $input['data_time'] == 'THIS_MONTH' ||
                    $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                    $q->whereBetween('created_at', getTime(($input['data_time'])));
                });
            })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date'])." 00:00:00", Functions::yearMonthDay($input['end_date'])." 23:59:59"]);
            })
            ->when(isset($input['bor_none']), function ($query) use ($input) {
                $query->when($input['bor_none'] == 'advanced', function ($q) use ($input) {
                    $q->where('the_rest', '>', 0);
                    })
                    ->when($input['bor_none'] == 'paid', function ($q) use ($input) {
                        $q->where('the_rest', 0);
                    });
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

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::deleting(function($order) {
            $order->orderDetails()->delete();
        });
    }

    public static function getAll()
    {
        return self::with('orderDetails', 'customer', 'paymentHistories')
            ->get();
    }
}
