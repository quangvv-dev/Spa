<?php

namespace App\Models;

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
}
