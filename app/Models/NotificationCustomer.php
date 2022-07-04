<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationCustomer extends Model
{
    protected $guarded = ['id'];
    protected $table = 'notifications_customers';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

}
