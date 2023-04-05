<?php

namespace App;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Branch;
use App\Models\ChamCong;
use App\Models\Department;
use App\Models\DonTu;
use App\Models\Location;
use App\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'phone',
        'avatar',
        'email',
        'birthday',
        'role',
        'gender',
        'mkt_id',
        'status_id',
        'active',
        'password',
        'group_id',
        'source_id',
        'telesales_id',
        'department_id',
        'branch_id',
        'address',
        'account_code',
        'description',
        'facebook',
        'is_leader',
        'branch_id',
        'caller_number',
        'location_id',
        'approval_code',
        'name_display'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function search($param)
    {
        $data = self::when(isset($param['search']), function ($query) use ($param) {
            $query->where('full_name', 'like', '%' . $param['search'] . '%')
                ->orWhere('phone', 'like', '%' . $param['search'] . '%');
        })->when(isset($param['branch_id']) && $param['branch_id'], function ($q) use ($param) {
            $q->where('branch_id', $param['branch_id']);
        })->when(isset($param['department_id']) && $param['department_id'], function ($q) use ($param) {
            $q->where('department_id', $param['department_id']);
        })
            ->latest('id')->paginate(StatusCode::PAGINATE_10);

        return $data;
    }


    public function getGenderTextAttribute()
    {
        return $this->gender == UserConstant::MALE ? 'Nam' : 'Nữ';
    }

    public function getActiveTextAttribute()
    {
        return $this->active == UserConstant::ACTIVE ? 'Hoạt động' : 'Không hoạt động';
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function getRoleTextAttribute()
    {
        $role = Role::select('name')->find($this->role);
        return isset($role) ? $role->name : '';
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }

    public function permission($permission = null)
    {
        @$pers = @json_decode($this->roles->permissions, true);
        if (is_array($pers)) {
            return in_array($permission, $pers);
        } else {
            return 0;
        }
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function chamCong(){
        return $this->hasMany(ChamCong::class,'ind_red_id','approval_code');
    }

    public function donTu(){
        return $this->hasMany(DonTu::class);
    }
}
