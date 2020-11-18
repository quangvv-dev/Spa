<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['id'];
    const  SCHEDULE_STATUS = [
//        [
//            'id'   => 1,
//            'name' => 'Hẹn gọi lại',
//        ],
        [
            'id' => 2,
            'name' => 'Đặt lịch',
        ],
        [
            'id' => 3,
            'name' => 'Đến/mua',
        ],
        [
            'id' => 4,
            'name' => 'Đến/chưa mua',
        ],
        [
            'id' => 5,
            'name' => 'Hủy lịch',
        ],
//        [
//            'id'   => 6,
//            'name' => 'Tất cả',
//        ],
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
        return $this->belongsTo(Customer::class, 'user_id', 'id')->withTrashed();
    }

    public function getDateScheduleAttribute()
    {
        return Carbon::parse($this->attributes['date'])->format('d/m/Y');
    }

    public function getNameStatusAttribute()
    {
        $key = array_keys(array_column(Schedule::SCHEDULE_STATUS, 'id'), $this->attributes['status']);
        return Schedule::SCHEDULE_STATUS[$key[0]]['name'];
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
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                });
        }

        $data = $data->count();

        return $data;
    }

    public static function countStatus($input)
    {
        $data = self::select('*', \DB::raw('COUNT(status) AS total'))->groupBy('status');

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
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                });
        }

        return $data->get();
    }

    public static function search($request)
    {
        $docs = self::orderBy('id', 'desc');

        if (!empty($request['search'])) {
            $docs = $docs->whereIn('status', $request['search']);
        }
        if (!empty($request['date'])) {
            $docs = $docs->where('date', $request['date']);
        } else {
            $docs = $docs->whereYear('date', Carbon::now()->format('Y'));
        }
        if (!empty($request['user'])) {
            $docs = $docs->where('creator_id', $request['user']);
        }
        if (!empty($request['category'])) {
            $docs = $docs->where('category_id', $request['category']);
        }
        if (!empty($request['customer'])) {
            $param = $request['customer'];
            $docs->whereHas('customer', function ($q) use ($param) {
                $q->where('phone', 'like', '%' . $param . '%');
            });
        }

        return $docs;
    }
}
