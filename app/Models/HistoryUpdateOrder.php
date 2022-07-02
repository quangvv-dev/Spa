<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class HistoryUpdateOrder extends Model
{
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
    public function support()
    {
        return $this->belongsTo(User::class, 'support_id', 'id')->withTrashed();
    }
    public function support2()
    {
        return $this->belongsTo(User::class, 'support2_id', 'id')->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
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

    public static function search($input, $select = '*')
    {
        $data = self::select($select)->orderBy('id', 'desc')->when(!empty($input['data_time']) && ($input['data_time'] == 'THIS_WEEK' ||
                $input['data_time'] == 'LAST_WEEK' ||
                $input['data_time'] == 'THIS_MONTH' ||
                $input['data_time'] == 'LAST_MONTH'), function ($q) use ($input) {
            $q->whereBetween('created_at', getTime(($input['data_time'])));
        })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })
            ->when(isset($input['user_id']), function ($query) use ($input) {
                $query->where('user_id', $input['user_id']);
            })->when(isset($input['type']), function ($query) use ($input) {
                $query->where('type', $input['type']);
            });
        return $data;
    }

}
