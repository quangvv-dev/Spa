<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    protected $guarded = ['id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'user_id',
//        'customer_id',
//        'parent_id',
//        'name',
//        'code',
//        'type',
//        'amount_of_work',
//        'date_from',
//        'date_to',
//        'time_from',
//        'time_to',
//        'document',
//        'description',
//        'priority',
//        'task_status_id',
//        'progress',
//        'taskmaster_id',
//        'department_id',
//        'sms_content',
//    ];

    const TYPE = [
        2 => 'Chăm sóc',
        1 => 'Gọi điện',
    ];

    const PRIORITY = [
        1 => 'Cao',
        2 => 'Trung bình',
        3 => 'Thấp',
    ];

    const PROGRESS = [
        0 => '0 %',
        1 => '10 %',
        2 => '20 %',
        3 => '30 %',
        4 => '40 %',
        5 => '50 %',
        6 => '60 %',
        7 => '70 %',
        8 => '80 %',
        9 => '90 %',
        10 => '100 %',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks', 'task_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function getNamePriorityAttribute()
    {
        if ($this->attributes['priority'] == 1) return 'Cao';
        if ($this->attributes['priority'] == 2) return 'Trung bình';
        if ($this->attributes['priority'] == 3) return 'Thấp';
    }

//    public function getDateFromAttribute()
//    {
//        return Carbon::parse($this->attributes['date_from'])->format('d-m-Y');
//    }

    public function getDateToAttribute()
    {
        return Carbon::parse($this->attributes['date_to'])->format('d-m-Y');
    }

    public static function getAll($input)
    {
        $idlogin = Auth::user()->id;
        $user = User::where('id', $idlogin)->first();
        $data = self::with('user', 'taskStatus', 'customer', 'department');

        if (isset($input)) {
            $data = $data->when(isset($input['task_id']), function ($query) use ($input) {
                $query->where('task_status_id', $input['task_id']);
            })
                ->when(isset($input['name']), function ($query) use ($input) {
                    $query->where('name', 'LIKE', '%' . $input['name'] . '%');
                })
                ->when(isset($input['status']), function ($query) use ($input) {
                    $query->whereIn('task_status_id', $input['status']);
                })
                ->when(isset($input['type']), function ($query) use ($input) {
                    $query->where('type', $input['type']);
                })->when(isset($input['type1']), function ($query) use ($input, $user) {
                    $query->when($input['type1'] == 'qf1', function ($q) {
                        $q->where('user_id', Auth::user()->id);
                    })
                        ->when($input['type1'] == 'qf2', function ($q) use ($user) {
                            $q->where('department_id', $user->department_id);
                        })
                        ->when($input['type1'] == 'qf3', function ($q) {
                            $task = \DB::table('user_tasks')->where('user_id', Auth::user()->id)->pluck('task_id')
                                ->toArray();
                            $q->find($task);
                        });
                });
        }

        $data = $data->orderBy('id', 'DESC')->get();

        return $data;
    }

    public function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class, 'task_status_id', 'id');
    }

    public function getDateScheduleAttribute()
    {
        return Carbon::parse($this->attributes['date_from'])->format('d/m/Y');
    }

    public static function search($input)
    {
        $data = self::when(isset($input['data_time']), function ($query) use ($input) {
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
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        })->orderByDesc('created_at');
        return $data;
    }
}
