<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Helpers\Functions;
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

    public static function getBooks($input)
    {
        $data = self::where('status', StatusCode::BOOK);

        if (isset($input)) {
            $data = $data->when(isset($input['data_time']), function ($query) use ($input) {
                $query->when($input['data_time'] == 'TODAY' ||
                    $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                    $q->whereDate('created_at', getTime(($input['data_time'])));
                })
                    ->when($input['data_time'] == 'THIS_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'THIS_MONTH' ||
                        $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                        $q->whereBetween('created_at', getTime(($input['data_time'])));
                    });
            })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date'])." 00:00:00", Functions::yearMonthDay($input['end_date'])." 23:59:59"]);
            });
        }

        $data = $data->get();

        return $data;
    }
}
