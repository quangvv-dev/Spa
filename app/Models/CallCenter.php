<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CallCenter extends Model
{
    protected $guarded = ['id'];
    protected $table = 'call_center';


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'dest_number', 'phone');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'caller_number', 'caller_number');
    }

    public function getExpiredTextAttribute()
    {

        if (!empty($this->answer_time)) {
            $minutes = floor(($this->answer_time / 60));
            $sec = round($this->answer_time % 60);
            return ($minutes > 0 ? $minutes . ' phút ' : '') . ($sec > 0 && $minutes < 1 ? $sec . ' giây' : '');
        }
        return '';
    }
}
