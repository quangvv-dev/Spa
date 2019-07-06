<?php

namespace App\Models;

use App\Constants\UserConstant;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];

    public static function search($param)
    {
        $data = self::with('status', 'marketing', 'category')
            ->when($param['search'], function ($query) use ($param) {
                $query->where('full_name', 'like', '%' . $param['search'] . '%')
                    ->orWhere('phone', 'like', '%' . $param['search'] . '%');
            })
            ->when($param['status'], function ($query) use ($param) {
                $query->whereHas('status', function ($q) use ($param) {
                    $q->where('status.name', $param['status']);
                });
            })
            ->when($param['group_id'], function ($query) use ($param) {
                $query->where('group_id', $param['status']);
            })
            ->when($param['telesales_id'], function ($query) use ($param) {
                $query->where('telesales_id', $param['telesales_id']);
            })
            ->latest()->paginate(10);

        return $data;
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function marketing()
    {
        return $this->belongsTo(User::class, 'mkt_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Status::class, 'group_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'member_id', 'id');
    }

    public function getGenderTextAttribute()
    {
        return $this->gender == UserConstant::MALE ? 'Nam' : 'Nữ';
    }

    public function getActiveTextAttribute()
    {
        return $this->active == UserConstant::ACTIVE ? 'Hoạt động' : 'Không hoạt động';
    }

    public function telesale()
    {
        return $this->belongsTo(User::class, 'telesales_id', 'id');
    }

    public function source_customer()//nguồn KH
    {
        return $this->belongsTo(Status::class, 'source_id', 'id');
    }
}
