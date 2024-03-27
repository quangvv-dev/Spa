<?php

namespace App\Models;

use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class CallCenter extends Model
{
    protected $guarded = ['id'];
    protected $table = 'call_center';
    public const ANSWERED = 'ANSWERED';
    public $timestamps = false;


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
            return ($minutes > 0 ? $minutes . ' phút ' : '') . ($sec > 0 ? $sec . ' giây' : '');
        }
        return '';
    }


    public function getAfterTimeAttribute()
    {
        $now = Date::now()->format('Y-m-d H:i:s');
        $count = CallCenter::where('dest_number', $this->dest_number)->count();
        if (isset($this->customer) && $count == 1) {
            $countdown = strtotime($now) - strtotime($this->customer->created_at);
            $days = ($countdown / 86400) > 1 ? floor($countdown / 86400) : 0;
            $hours = floor(($countdown % 86400) / 3600);
            $minutes = round((($countdown % 86400) % 3600) / 60);
            return ($days > 0 ? $days . ' ngày ' : '') . ($hours > 0 ? $hours . ' giờ ' : '') . ($minutes > 0 && $days < 1 ? $minutes . ' phút' : '');
        }
        return '';
    }

    public static function search($param, $select = '*')
    {
        $data = self::select($select)->when(isset($param['call_status']) && $param['call_status'], function ($q) use ($param) {
            $q->where('call_status', $param['call_status']);
        })->when(isset($param['caller_number']) && $param['caller_number'], function ($q) use ($param) {
            $q->where('caller_number', $param['caller_number']);
        })->when(isset($param['dest_number']) && $param['dest_number'], function ($q) use ($param) {
            $q->where('dest_number', $param['dest_number']);
        })->when(isset($param['start_date']) && isset($param['end_date']), function ($q) use ($param) {
            $q->whereBetween('start_time', [
                Functions::yearMonthDay($param['start_date']) . " 00:00:00",
                Functions::yearMonthDay($param['end_date']) . " 23:59:59",
            ]);
        });
        return $data->orderByDesc('id');
    }
}
