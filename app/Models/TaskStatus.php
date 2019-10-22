<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    protected $table = 'task_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_status_id', 'id');
    }
}
