<?php

namespace App\Models;

use App\Constants\UserConstant;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    protected $guarded = ['id'];

    public static function search($param)
    {
        $data = self::with('status', 'marketing', 'category');
        if (isset($param)) {
            $data = $data->when(isset($param['search']), function ($query) use ($param) {
                    $query->where(function ($q) use ($param) {
                        $q->where('full_name', 'like', '%' . $param['search'] . '%')
                            ->orWhere('phone', 'like', '%' . $param['search'] . '%');
                    });
                })
                ->when(isset($param['status']), function ($query) use ($param) {
                    $query->whereHas('status', function ($q) use ($param) {
                        $q->where('status.name', $param['status']);
                    });
                })
                ->when(isset($param['group']), function ($query) use ($param) {
                    $query->where('group_id', $param['group']);
                })
                ->when(isset($param['telesales']), function ($query) use ($param) {
                    $query->where('telesales_id', $param['telesales']);
                })
                ->when(isset($param['data_time']), function ($query) use ($param) {
                    $query->when($param['data_time'] == 'TODAY' ||
                        $param['data_time'] == 'YESTERDAY', function ($q) use ($param) {
                        $q->whereDate('created_at', getTime(($param['data_time'])));
                    })
                    ->when($param['data_time'] == 'THIS_WEEK' ||
                        $param['data_time'] == 'LAST_WEEK' ||
                        $param['data_time'] == 'THIS_MONTH' ||
                        $param['data_time'] == 'LAST_MONTH', function ($q) use ($param) {
                        $q->whereBetween('created_at', getTime(($param['data_time'])));
                    });
                })
                ->latest()->paginate(10);
        }

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

    public function category()
    {
        return $this->belongsTo(Category::class, 'group_id', 'id');
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

    public function getStatisticsUsers()
    {
        return $this->with('marketing')->select('mkt_id', \DB::raw('count(id) as count'))
            ->whereNotNull('mkt_id')
            ->groupBy('mkt_id');
    }

    public static function getAll()
    {
        return self::with('status')->get();
    }

    public static function getDataOfYears()
    {
        return self::select(DB::raw("DATE_FORMAT(created_at,'%M') as monthNum"),
            DB::raw('IFNULL(count(*),0) as totalCustomer'))
            ->groupBy('monthNum')
            ->orderBy('created_at', 'ASC')
            ->get();
    }
}
