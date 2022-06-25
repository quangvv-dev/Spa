<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationCustomer extends Model
{
    protected $guarded = ['id'];
    protected $table = 'notifications_customers';
    
    public function getDataAttribute()
    {
        return @json_decode((array)$this->data, true);
    }

    public function setDataAttribute()
    {
        return @json_encode((array)$this->data, true);
    }

}
