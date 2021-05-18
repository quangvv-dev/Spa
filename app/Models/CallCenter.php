<?php

namespace App\Models;

use App\Helpers\Functions;
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
            return ($minutes > 0 ? $minutes . ' phút ' : '') . ($sec > 0 ? $sec . ' giây' : '');
        }
        return '';
    }

    public static function search($param)
    {
        $data = self::when(isset($param['call_status']) && $param['call_status'], function ($q) use ($param) {
            $q->where('call_status', $param['call_status']);
        })->when(isset($param['caller_number']) && $param['caller_number'], function ($q) use ($param) {
            $q->where('caller_number', $param['caller_number']);
        })->when(isset($param['dest_number']) && $param['dest_number'], function ($q) use ($param) {
            $q->where('dest_number', $param['dest_number']);
        })
            ->when($param['data_time'] == 'TODAY' ||
                $param['data_time'] == 'YESTERDAY', function ($q) use ($param) {
                $q->whereDate('start_time', getTime(($param['data_time'])));
            })
            ->when($param['data_time'] == 'THIS_WEEK' ||
                $param['data_time'] == 'LAST_WEEK' ||
                $param['data_time'] == 'THIS_MONTH' ||
                $param['data_time'] == 'LAST_MONTH', function ($q) use ($param) {
                $q->whereBetween('start_time', getTime(($param['data_time'])));
            })
            ->when(isset($param['start_date']) && isset($param['end_date']), function ($q) use ($param) {
                $q->whereBetween('start_time', [
                    Functions::yearMonthDay($param['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($param['end_date']) . " 23:59:59",
                ]);
            });
        return $data->orderByDesc('id');
    }
}
