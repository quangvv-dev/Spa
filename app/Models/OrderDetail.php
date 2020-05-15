<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Functions;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'booking_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public static function getAll()
    {
        return self::get();
    }

    public static function getCustomerSearch($input)
    {
        $data = self::when(isset($input['data_time']), function ($query) use ($input) {
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
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            })->get();
        $response = [];
        foreach ($data as $item) {
            $name = Status::getStatusWithId($item->user->source_id);
            if ($name) {
                $response[$name][]= (int)$item->total_price;
            }
        }
        return $response;
    }
}
