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

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id', 'id');
    }

    public function getNameTypeAttribute()
    {
        $map = [
            StatusCode::TYPE_ORDER_PROCESS => 'Trừ liệu trình',
            StatusCode::TYPE_ORDER_GUARANTEE => 'Đã bảo hành',
            StatusCode::TYPE_ORDER_RESERVE => 'Đang bảo lưu',
        ];

        return $map[$this->type] ?? null;
    }

    public static function search($input)
    {
        $data = self::orderBy('id', 'desc')->when($input['data_time'] == 'THIS_WEEK' ||
            $input['data_time'] == 'LAST_WEEK' ||
            $input['data_time'] == 'THIS_MONTH' ||
            $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
            $q->whereBetween('created_at', getTime(($input['data_time'])));
        })
            ->when(isset($input['user_id']), function ($query) use ($input) {
                $query->where('user_id', $input['user_id']);
            });
        return $data;
    }

}
