<?php

namespace App\Models;

use App\Constants\UserConstant;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }

    public static function search($input)
    {
        $data = self::with('user', 'orderDetails');

        if ($input) {
            $data = $data->when($input['group'], function ($query) use ($input) {
                $query->whereHas('user', function ($q) use ($input) {
                    $q->where('group_id', $input['group']);
                });
            })
            ->when($input['telesale'], function ($query) use ($input) {
                $query->whereHas('user', function ($q) use ($input) {
                   $q->where('telesales_id', $input['telesale']);
                });
            })
            ->when($input['marketing'], function ($query) use ($input) {
                $query->whereHas('user', function ($q) use ($input) {
                   $q->where('mkt_id', $input['marketing']);
                });
            })
            ->when($input['service'], function ($query) use ($input) {
                $query->whereHas('orderDetails', function ($q) use ($input) {
                   $q->where('booking_id', $input['service']);
                });
            })
            ->when($input['customer'], function ($query) use ($input) {
                $query->whereHas('user', function ($q) use ($input) {
                   $q->where('full_name', 'like', '%'. $input['customer']. '%')
                   ->orWhere('phone', 'like', '%'. $input['customer']. '%');
                });
            });


        }

        return $data->paginate(10);
    }
}
