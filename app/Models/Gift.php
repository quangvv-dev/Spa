<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Services::class, 'product_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public static function search($input)
    {
        $data = self::when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [
                Functions::yearMonthDayTime($input['start_date']),
                Functions::yearMonthDayTime($input['end_date']),
            ]);
        })->when(isset($input['branch_id']), function ($query) use ($input) {
            $query->where('branch_id', $input['branch_id']);
        })->when(isset($input['order_id']), function ($query) use ($input) {
            $query->where('order_id', $input['order_id']);
        })->when(isset($input['customer_id']), function ($query) use ($input) {
            $query->where('customer_id', $input['customer_id']);
        })->when(isset($input['product_id']), function ($query) use ($input) {
            $query->where('product_id', $input['product_id']);
        });
        return $data;
    }
}
