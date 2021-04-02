<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
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
        'genitive_id',
        'full_name',
        'account_code',
        'address',
        'phone',
        'birthday',
        'gender',
        'description',
        'facebook',
        'avatar',
        'fb_name',
        'membership',
        'branch_id',
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    const VIP_STATUS = 10000000;


    public static function applySearchConditions($builder, $conditions)
    {
        $builder->when(isset($conditions['search']), function ($query) use ($conditions) {
            $query->where(function ($q) use ($conditions) {
                $q->where('full_name', 'like', '%' . $conditions['search'] . '%')
                    ->orWhere('phone', 'like', '%' . $conditions['search'] . '%')
                    ->orWhere('membership', $conditions['search']);
            });
        })
            ->when(isset($conditions['status']), function ($query) use ($conditions) {
                $query->whereHas('status', function ($q) use ($conditions) {
                    $q->where('name', $conditions['status']);
                });
            })
            ->when(isset($conditions['group']), function ($query) use ($conditions) {
                $group_customer = CustomerGroup::where('category_id', $conditions['group'])->pluck('customer_id')->toArray();
                $query->whereIn('id', $group_customer);
            })
            ->when(isset($conditions['telesales']), function ($query) use ($conditions) {
                $query->where('telesales_id', $conditions['telesales']);
            })
            ->when(isset($conditions['marketing']), function ($query) use ($conditions) {
                $query->where('mkt_id', $conditions['marketing']);
            })
            ->when(isset($conditions['source']), function ($query) use ($conditions) {
                $query->where('source_id', $conditions['source']);
            })
            ->when(isset($conditions['data_time']), function ($query) use ($conditions) {
                $query->when($conditions['data_time'] == 'TODAY' ||
                    $conditions['data_time'] == 'YESTERDAY', function ($q) use ($conditions) {
                    $q->whereDate('created_at', getTime(($conditions['data_time'])));
                })
                    ->when($conditions['data_time'] == 'THIS_WEEK' ||
                        $conditions['data_time'] == 'LAST_WEEK' ||
                        $conditions['data_time'] == 'THIS_MONTH' ||
                        $conditions['data_time'] == 'LAST_MONTH', function ($q) use ($conditions) {
                        $q->whereBetween('created_at', getTime(($conditions['data_time'])));
                    });
            })
            ->when(isset($conditions['invalid_account']), function ($query) use ($conditions) {
                $query->when($conditions['invalid_account'] == 0, function ($q) use ($conditions) {
                    $q->onlyTrashed();
                });
            })
            ->when(isset($conditions['birthday']), function ($query) use ($conditions) {
                $query->whereRaw('DATE_FORMAT(birthday, "%m-%d") = ?', Carbon::now()->format('m-d'));
            });

        return $builder;
    }

    public static function search($param)
    {
        $user = Auth::user();
        $data = self::latest();
        if ($user->role == UserConstant::TELESALES && setting('view_customer_sale') != StatusCode::ON) {
            if ($user->is_leader == UserConstant::IS_LEADER) {
                $data = $data->with('status', 'marketing', 'categories', 'orders', 'source_customer', 'groupComments');
            } else {
                $data = $data->where('telesales_id', $user->id);
            }
        } else {
            $data = $data->with('status', 'marketing', 'categories', 'orders', 'source_customer', 'groupComments');
        }
        if (isset($param['branch_id']) && $param['branch_id']) {
            $data = $data->where('branch_id', $param['branch_id']);
        }
        if (count($param)) {
            static::applySearchConditions($data, $param);
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

    public function genitive()
    {
        return $this->belongsTo(Genitive::class, 'genitive_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'customer_groups', 'customer_id', 'category_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'member_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class, 'user_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function getGenderTextAttribute()
    {
        return $this->gender == UserConstant::MALE ? 'Nam' : 'Nữ';
    }

    public function getActiveTextAttribute()
    {
        return $this->active == UserConstant::ACTIVE ? 'Hoạt động' : 'Không hoạt động';
    }

    public function getSchedulesTextAttribute()
    {

        $arr = [];
        $schedules = Schedule::select(\DB::raw('COUNT(id) AS count'), 'user_id', 'status')->where('user_id', $this->id);
        $all_count = $schedules->count();
        $arr[] = '<span class="bold text-info">' . 'Tất cả : ' . $all_count . '</span> ';
        $schedules = $schedules->groupBy('user_id', 'status')->get();
        if (count($schedules)) {
            foreach ($schedules as $item) {
                if ($item->status == 3) { //đến- mua
                    $arr[] = '<span class="bold text-success">' . 'Đến Mua : ' . $item->count . '</span>';
                } elseif ($item->status == 4) {//đến - không mua
                    $arr[] = '<span class="bold text-warning">' . 'Đến không Mua : ' . $item->count . '</span>';
                } elseif ($item->status == 5) {//Hủy
                    $arr[] = '<span class="bold text-danger">' . 'Hủy :' . $item->count . '</span> ';
                }
            }
        }
        return implode(",", $arr);
    }

    public function getGroupTextAttribute()
    {
        $text = [];
        $group = CustomerGroup::where('customer_id', $this->id)->with('category')->get();
        if (count($group)) {
            foreach ($group as $item) {
                if (isset($item->category)) {
                    $text[] = $item->category->name;
                }
            }
        }
        $text = implode($text, ',');
        return $text;
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

    public function groupComments()
    {
        return $this->hasMany(GroupComment::class, 'customer_id', 'id');
    }

    public function groupCustomer()
    {
        return $this->hasMany(CustomerGroup::class, 'customer_id', 'id');
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
            'order_detail' => function ($query) use ($input) {
                $query->when(count($input['list_booking']), function ($query) use ($input) {
                    $query->whereIn('booking_id', $input['list_booking']);
                })
                    ->when(isset($input['data_time']), function ($query) use ($input) {
                        $query->when($input['data_time'] == 'TODAY' ||
                            $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                            $q->whereDate('created_at', getTime(($input['data_time'])));
                        })
                            ->when($input['data_time'] == 'THIS_WEEK' ||
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
                    })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                        $q->where('branch_id', $input['branch_id']);

                    });
            },
        ]);

        $data = $data->has('order_detail')->get();
        $revenueMale = 0;
        $revenueFemale = 0;
        foreach ($data as $item) {
            if ($item->gender == UserConstant::MALE) {
                $revenueMale += $item->order_detail->sum('total_price');
            } else {
                $revenueFemale += $item->order_detail->sum('total_price');
            }
        }

        return $result = [
            [
                'name' => 'Nam',
                'revenue' => $revenueMale,
            ],
            [
                'name' => 'Nữ',
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
                $query->where('mkt_id', $input['user_id']);
            })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            });
        }

        return $data->count();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
