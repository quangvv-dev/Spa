<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public static function getAll($input)
    {
        $idlogin = Auth::user()->id;

        $data = self::when(isset($input['task_id']), function ($query) use ($input) {
            $query->where('id', $input['task_id']);
        })
        ->with(['tasks' => function($query) use($input, $idlogin) {
            $query->when(isset($input['name']), function ($query) use ($input) {
                $query->where('name', 'like', '%'. $input['name'] . '%');

            })
            ->where('user_id', $idlogin)
            ->when(isset($input['type']), function ($query) use ($input, $idlogin) {
                $query->where('type', $input['type']);
            });
        }]);

        return $data->get();
    }
}
