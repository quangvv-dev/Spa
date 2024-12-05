<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiveMoney extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
