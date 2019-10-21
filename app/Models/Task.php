<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'customer_id',
        'parent_id',
        'name',
        'code',
        'type',
        'amount_of_work',
        'date_from',
        'date_to',
        'time_from',
        'time_to',
        'document',
        'description',
        'priority',
    ];

    const TYPE = [
       1 => 'Gọi điện',
       2 => 'Hẹn gặp',
       3 => 'Email',
       4 => 'Ăn trưa',
       5 => 'Kỷ niệm',
    ];

    const PRIORITY = [
       1 => 'Cao',
       2 => 'Trung bình',
       3 => 'Thấp',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks', 'task_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getNamePriorityAttribute()
    {
        if ($this->attributes['priority'] == 1) return 'Cao';
        if ($this->attributes['priority'] == 2) return 'Trung bình';
        if ($this->attributes['priority'] == 3) return 'Thấp';
    }

    public function getDateFromAttribute()
    {
        return Carbon::parse($this->attributes['date_from'])->format('d-m-Y');
    }

    public function getDateToAttribute()
    {
        return Carbon::parse($this->attributes['date_to'])->format('d-m-Y');
    }

    public static function getAll()
    {
        return self::with('user.department')->get();
    }
}
