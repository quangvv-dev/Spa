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
            ->when(isset($input['type']), function ($query) use ($input, $idlogin) {
                $query->when($input['type'] == 'qf1', function ($q) use ($idlogin) {
                    $q->where('user_id', $idlogin);
                })
                ->when($input['type'] == 'qf2', function ($q) use ($idlogin) {
                    $q->where('taskmaster_id', $idlogin);
                })->when($input['type'] == 'qf3', function ($q1) use ($idlogin) {
                    $q1->whereHas('users', function ($q) use ($idlogin) {
                        $q->where('users.id', $idlogin);
                    });
                });
            });
        }]);

        return $data->get();
    }
}
