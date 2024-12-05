<?php

namespace App\Models;

use App\User;
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
        $user = User::where('id', $idlogin)->first();

        $data = self::when(isset($input['task_id']), function ($query) use ($input) {
            $query->where('id', $input['task_id']);
        })
        ->with(['tasks' => function($query) use($input, $idlogin, $user) {
            $query->when(isset($input['name']), function ($query) use ($input) {
                $query->where('name', 'like', '%'. $input['name'] . '%');

            })
            ->when(isset($input['type']), function ($query) use ($input, $idlogin) {
                $query->where('type', $input['type']);
            })
            ->when(isset($input['type1']), function ($query) use ($input, $idlogin, $user) {
                $query->when($input['type1'] == 'qf1', function ($q) use ($idlogin) {
                    $q->where('user_id', $idlogin);
                })
                ->when($input['type1'] == 'qf2', function ($q) use ($idlogin, $user) {
                    $q->where('department_id', $user->department_id);
                })->when($input['type1'] == 'qf3', function ($q1) use ($idlogin) {
                    $q1->whereHas('users', function ($q) use ($idlogin) {
                        $q->where('users.id', $idlogin);
                    });
                });
            });
        }]);

        return $data->get();
    }
}
