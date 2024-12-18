<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class, 'role', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    /**
     * List permission
     *
     * @param $permission
     *
     * @return bool|int
     */
    public function hasAccess($permission)
    {
        @$pers = json_decode($this->permissions, true);
        if (is_array($pers)) {
            return in_array($permission, $pers);
        } else {
            return 0;
        }
    }

    /**
     * Search data index
     *
     * @param $dataSearch
     * @return mixed
     */
    public static function search($dataSearch)
    {
        $data = self::when($dataSearch['searchName'], function ($query) use ($dataSearch) {
            return $query->where('name', 'like', '%' . $dataSearch['searchName'] . '%')
                ->orWhere('description', 'like', '%' . $dataSearch['searchName'] . '%');
        })->when(!empty($dataSearch['department_id']), function ($query) use ($dataSearch) {
            return $query->where('department_id', $dataSearch['department_id']);
        });
        $data = $data->paginate(StatusCode::PAGINATE_10);

        return $data;
    }
}
