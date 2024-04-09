<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Functions;
use Illuminate\Support\Facades\DB;

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

   public const ROLE = [
        1 => 'Toàn phòng ban',
    ];
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
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function task_status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
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
        $data = self::with('user', 'taskStatus', 'customer', 'department')->where('type', 2);

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
        $data = self::when(!empty($input['start_date']) && !empty($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('date_from', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        })
            ->when(isset($input['user_id']) && isset($input['user_id']), function ($q) use ($input) {
                $q->where('user_id', $input['user_id']);
            })->when(isset($input['member']) && isset($input['member']), function ($q) use ($input) {
                $q->whereIn('user_id', $input['member']);
            })->when(isset($input['customer_id']) && isset($input['customer_id']), function ($q) use ($input) {
                $q->where('customer_id', $input['customer_id']);
            })->when(isset($input['type']) && $input['type'], function ($q) use ($input) {
                $q->where('type', $input['type']);
            })->when(isset($input['branch_id']) && isset($input['branch_id']), function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })->when(isset($input['task_status_id']) && isset($input['task_status_id']), function ($q) use ($input) {
                $q->where('task_status_id', $input['task_status_id']);
            })->when(isset($input['date_from']) && isset($input['date_from']), function ($q) use ($input) {
                $q->where('date_from', $input['date_from']);
            })
            ->orderByDesc('date_from');
        return $data;
    }

    public static function groupByStatus($input)
    {
        $data = self::select('ts.id','ts.name',DB::raw('COUNT(tasks.id) as count'))
            ->leftJoin('task_status as ts','tasks.task_status_id','=','ts.id')
            ->when(!empty($input['start_date']) && !empty($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('tasks.date_from', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        })
            ->when(isset($input['user_id']) && isset($input['user_id']), function ($q) use ($input) {
                $q->where('tasks.user_id', $input['user_id']);
            })->when(isset($input['member']) && isset($input['member']), function ($q) use ($input) {
                $q->whereIn('user_id', $input['member']);
            })->when(isset($input['customer_id']) && isset($input['customer_id']), function ($q) use ($input) {
                $q->where('tasks.customer_id', $input['customer_id']);
            })->when(isset($input['type']) && $input['type'], function ($q) use ($input) {
                $q->where('tasks.type', $input['type']);
            })->when(isset($input['branch_id']) && isset($input['branch_id']), function ($q) use ($input) {
                $q->where('tasks.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('tasks.branch_id', $input['group_branch']);
            })->when(isset($input['task_status_id']) && isset($input['task_status_id']), function ($q) use ($input) {
                $q->where('tasks.task_status_id', $input['task_status_id']);
            })->when(isset($input['date_from']) && isset($input['date_from']), function ($q) use ($input) {
                $q->where('tasks.date_from', $input['date_from']);
            })->groupBy('ts.id');
        return $data;
    }
}
