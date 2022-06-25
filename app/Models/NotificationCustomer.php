<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationCustomer extends Model
{
    protected $guarded = ['id'];
    protected $table = 'notifications_customers';
    
//    public function getDataAttribute($data)
//    {
//        return @json_decode((array)$data, true);
//    }
//
//    public function setDataAttribute($data)
//    {
//        return @json_encode((array)$data, true);
//    }

}
