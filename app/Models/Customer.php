<?php

namespace App\Models;

use App\Constants\UserConstant;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use SoftDeletes;
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
                ->when(isset($param['invalid_account']), function ($query) use ($param) {
                    $query->when($param['invalid_account'] == 0, function ($q) use ($param) {
                        $q->onlyTrashed();
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
        return self::with('status', 'marketing', 'category', 'orders', 'telesale', 'source_customer')
            ->get();
    }

    public static function getDataOfYears($input)
    {
        $data = self::with('status', 'marketing', 'category');

        if (isset($input)) {
            $data = $data->when(isset($input['data_time']), function ($query) use ($input) {
                $query->when($input['data_time'] == 'TODAY' ||
                    $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                    $q->whereDate('created_at', getTime(($input['data_time'])));
                })
                    ->when($input['data_time'] == 'THIS_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'THIS_MONTH' ||
                        $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                        $q->whereBetween('created_at', getTime(($input['data_time'])));
                    });
            });
        }

        $data = $data->select(DB::raw("DATE_FORMAT(created_at,'%M') as monthNum"),
            DB::raw('IFNULL(count(*),0) as totalCustomer'))
        ->groupBy('monthNum')
        ->orderBy('created_at', 'ASC')
        ->get();

        return $data;
    }

    public static function getRevenueByGender($input)
    {
        $data = self::with('orders');

        if (isset($input)) {
            $data = $data->when(isset($input['data_time']), function ($query) use ($input) {
                $query->when($input['data_time'] == 'TODAY' ||
                    $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                    $q->whereDate('created_at', getTime(($input['data_time'])));
                })
                    ->when($input['data_time'] == 'THIS_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'LAST_WEEK' ||
                        $input['data_time'] == 'THIS_MONTH' ||
                        $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                        $q->whereBetween('created_at', getTime(($input['data_time'])));
                    });
            });
        }

        $dataMale = $data->where('gender', UserConstant::MALE)->get();
        $dataFemale = $data->where('gender', UserConstant::FEMALE)->get();

        $revenueMale = 0;
        $revenueFemale = 0;

        foreach($dataMale as $item) {
            $revenueMale += $item->orders->sum('all_total');
        }

        foreach($dataFemale as $item) {
            $revenueFemale += $item->orders->sum('all_total');
        }

        return $result = [
            [
                'name' => 'Nam',
                'revenue' => $revenueMale
            ],
            [
                'name' => 'Nữ',
                'revenue' => $revenueFemale
            ]
        ];
    }
}
