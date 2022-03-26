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

    public static function getBooks($input, $select = '*')
    {
        $data = self::select($select)->when(isset($input['data_time']), function ($query) use ($input) {
            $query->when($input['data_time'] == 'TODAY' ||
                $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                $q->whereDate('date', getTime(($input['data_time'])));
            })
                ->when($input['data_time'] == 'THIS_WEEK' ||
                    $input['data_time'] == 'LAST_WEEK' ||
                    $input['data_time'] == 'THIS_MONTH' ||
                    $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                    $q->whereBetween('date', getTime($input['data_time']));
                });
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('date', [
                Functions::yearMonthDay($input['start_date']),
                Functions::yearMonthDay($input['end_date']),
            ]);
        })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(isset($input['status_schedule']) && $input['status_schedule'], function ($q) use ($input) {
            $q->where('status', $input['status_schedule']);
        })->when(isset($input['creator_id']) && $input['creator_id'], function ($q) use ($input) {
            $q->where('creator_id', $input['creator_id']);
        });

        $data = $data->count();

        return $data;
    }

    public static function getBooks2($input, $select = '*')
    {
        $data = self::select($select)->when(isset($input['data_time']), function ($query) use ($input) {
            $query->when($input['data_time'] == 'TODAY' ||
                $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                $q->whereDate('date', getTime(($input['data_time'])));
            })
                ->when($input['data_time'] == 'THIS_WEEK' ||
                    $input['data_time'] == 'LAST_WEEK' ||
                    $input['data_time'] == 'THIS_MONTH' ||
                    $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                    $q->whereBetween('date', getTime($input['data_time']));
                });
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('date', [
                Functions::yearMonthDay($input['start_date']),
                Functions::yearMonthDay($input['end_date']),
            ]);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(isset($input['status_schedule']) && $input['status_schedule'], function ($q) use ($input) {
            $q->where('status', $input['status_schedule']);
        })->when(isset($input['creator_id']) && $input['creator_id'], function ($q) use ($input) {
            $q->where('creator_id', $input['creator_id']);
        });

        return $data;
    }

    public static function countStatus($input)
    {
        $data = self::select('*', \DB::raw('COUNT(status) AS total'))->groupBy('status');

        if (isset($input)) {
            $data = $data->when(isset($input['data_time']), function ($query) use ($input) {
                $query->when($input['data_time'] == 'TODAY' ||
                    $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                    $q->whereDate('date', getTime(($input['data_time'])));
                })
                    ->when($input['data_time'] == 'THIS_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'THIS_MONTH' ||
                        $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                        $q->whereBetween('date', getTime(($input['data_time'])));
                    });
            })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['user']) && $input['user'], function ($q) use ($input) {
                $q->where('creator_id', $input['user']);
            })
                ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                    $q->whereBetween('date', [
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
        if (!empty($request['date'])) {
            $docs = $docs->where('date', $request['date']);
        } else {
            $docs = $docs->whereYear('date', Carbon::now()->format('Y'));
        }
        $docs->when(isset($request['branch_id']), function ($q) use ($request) {
            $q->where('branch_id', $request['branch_id']);
        })
            ->when(isset($request['start_date']) && isset($request['end_date']), function ($q) use ($request) {
                $q->whereBetween('date', [
                    Functions::yearMonthDay($request['start_date']).' 00:00',
                    Functions::yearMonthDay($request['end_date']).' 23:59',
                ]);
            });

        if (!empty($request['search'])) {
            $docs = $docs->whereIn('status', $request['search']);
        }
        if (isset($request['group_user']) && count($request['group_user'])) {
            $docs = $docs->whereIn('user_id', $request['group_user']);
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
        if (!empty($request['status'])) {
            $docs->whereHas('customer', function ($q) use ($request) {
                $q->where('source_id', $request['status']);
            });
        }

        return $docs;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
