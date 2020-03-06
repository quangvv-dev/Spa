<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\User;
use Illuminate\Database\Eloquent\Model;

class HistoryUpdateOrder extends Model
{
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getNameTypeAttribute()
    {
        $map = [
            StatusCode::TYPE_ORDER_PROCESS   => 'Trừ liệu trình',
            StatusCode::TYPE_ORDER_GUARANTEE => 'Đã bảo hành',
            StatusCode::TYPE_ORDER_RESERVE   => 'Đang bảo lưu',
        ];

        return $map[$this->type] ?? null;
    }

}
