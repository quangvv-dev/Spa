<?php

namespace App\Models;

use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mkt_id',
        'telesales_id',
        'source_id',
        'status_id',
        'full_name',
        'account_code',
        'address',
        'phone',
        'birthday',
        'gender',
        'description',
        'facebook',
        'avatar',
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    const VIP_STATUS = 8000000;

    public static function search($param)
    {
        $data = self::with('status', 'marketing', 'categories', 'orders', 'source_customer');
        if (count($param)) {

            $data = $data->when(isset($param['search']), function ($query) use ($param) {
                $query->where(function ($q) use ($param) {
                    $q->where('full_name', 'like', '%' . $param['search'] . '%')
                        ->orWhere('phone', 'like', '%' . $param['search'] . '%');
                });
            })
                ->when(isset($param['status']), function ($query) use ($param) {
                    $query->whereHas('status', function ($q) use ($param) {
                        $q->where('name', $param['status']);
                    });
                })
                ->when(isset($param['group']), function ($query) use ($param) {
                    $query->whereHas('categories', function ($q) use ($param) {
                        $q->where('categories.id', $param['group']);
                    });
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
                ->when(isset($param['birthday']), function ($query) use ($param) {
                    $query->whereRaw('DATE_FORMAT(birthday, "%m-%d") = ?', Carbon::now()->format('m-d'));
                });
        }

        return $data->latest()->paginate(20);
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'customer_groups', 'customer_id', 'category_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'member_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function getGenderTextAttribute()
    {
        return $this->gender == UserConstant::MALE ? 'Nam' : 'Nữ';
    }

    public function getActiveTextAttribute()
    {
        return $this->active == UserConstant::ACTIVE ? 'Hoạt động' : 'Không hoạt động';
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::deleting(function ($customer) {
            $customer->orders()->delete();
        });
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
        $data = self::with('status', 'marketing', 'category', 'orders', 'telesale', 'source_customer');
        return $data->get();
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
            })
                ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
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
        $data = self::with([
            'orders' => function ($query) use ($input) {
                $query->when(isset($input['order_id']), function ($query) use ($input) {
                    $query->whereIn('id', $input['order_id']);
                })
                    ->when(isset($input['data_time']), function ($query) use ($input) {
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
                    })
                    ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                        $q->whereBetween('created_at', [
                            Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                            Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                        ]);
                    });
            },
        ])
            ->has('orders');

        $data = $data->get();
        $revenueMale = 0;
        $revenueFemale = 0;

        foreach ($data as $item) {
            if ($item->gender == UserConstant::MALE) {
                $revenueMale += $item->orders->sum('gross_revenue');
            } else {
                $revenueFemale += $item->orders->sum('gross_revenue');
            }
        }

        return $result = [
            [
                'name'    => 'Nam',
                'revenue' => $revenueMale,
            ],
            [
                'name'    => 'Nữ',
                'revenue' => $revenueFemale,
            ],
        ];
    }

    public static function count($input)
    {
        $data = [];

        if (isset($input)) {
            $data = self::when(isset($input['data_time']), function ($query) use ($input) {
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
            })->when(isset($input['user_id']), function ($query) use ($input) {
                $query->where(function ($query) use ($input) {
                    $query->where('mkt_id', $input['user_id']);
                });
            })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            });
        }

        return $data->get();
    }
}
