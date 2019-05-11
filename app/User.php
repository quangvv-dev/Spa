<?php

namespace App;

use App\Constants\UserConstant;
use App\Models\Status;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
        'branch_id',
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

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function marketing()
    {
        return $this->belongsTo(User::class, 'mkt_id');
    }

    public function getGenderTextAttribute()
    {
        return $this->gender == UserConstant::MALE ? 'Nam' : 'Nữ';
    }

    public function getActiveTextAttribute()
    {
        return $this->active == UserConstant::ACTIVE ? 'Hoạt động' : 'Không hoạt động';
    }

    public function getRoleTextAttribute()
    {
        if ($this->role == UserConstant::ADMIN) {
            return 'Admin';
        }

        if ($this->role == UserConstant::MARKETING) {
            return 'Marketing';
        }

        if ($this->role == UserConstant::TELESALES) {
            return 'Telesales';
        }

        if ($this->role == UserConstant::WAITER) {
            return 'Lễ tân';
        }

        if ($this->role == UserConstant::TECHNICIANS) {
            return 'Kỹ thuật viên';
        }
        if ($this->role == UserConstant::CUSTOMER) {
            return 'Khách hàng';
        }
    }

    public function getStatisticsUsers()
    {
        return $this->with('marketing')->select('mkt_id', \DB::raw('count(id) as count'))
            ->whereNotNull('mkt_id')
            ->groupBy('mkt_id');
    }

//    public function getDateAttribute()
//    {
//        return \Carbon\Carbon::parse($this->birthday)->format('d-m-y');
//    }
//
//    public function setDateAttribute()
//    {
//        return \Carbon\Carbon::parse($this->birthday)->format('Y-m-d');
//    }
}
