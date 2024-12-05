<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchedulesSms extends Model
{
    protected $guarded = ['id'];
    protected $table = 'schedules_sms';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'phone', 'phone');
    }
}
