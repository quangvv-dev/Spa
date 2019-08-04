<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['id'];
    const  SCHEDULE_STATUS = [
        [
            'id' => 1,
            'name' => 'Hẹn gọi lại',
        ],
        [
            'id' => 2,
            'name' => 'Đặt lịch',
        ],
        [
            'id' => 3,
            'name' => 'Đã đến',
        ],
        [
            'id' => 4,
            'name' => 'Không đến',
        ],
        [
            'id' => 5,
            'name' => 'Hủy',
        ]
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'person_action', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }

    public function getNameStatusAttribute()
    {
        if ($this->status == Schedule::SCHEDULE_STATUS[0]['id']) {
            return 'Hẹn gọi lại';
        }

        if ($this->status == Schedule::SCHEDULE_STATUS[1]['id']) {
            return 'Đặt lịch';
        }

        if ($this->status == Schedule::SCHEDULE_STATUS[2]['id']) {
            return 'Đã đến';
        }

        if ($this->status == Schedule::SCHEDULE_STATUS[3]['id']) {
            return 'Không đến';
        }

        if ($this->status == Schedule::SCHEDULE_STATUS[4]['id']) {
            return 'Hủy';
        }
    }
}
