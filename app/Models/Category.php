<?php

namespace App\Models;

use App\Helpers\Functions;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $table = 'categories';

    public function categories()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function services()
    {
        return $this->hasMany(Services::class, 'category_id', 'id');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_groups', 'category_id', 'customer_id');
    }

    public static function search($input)
    {
        $data = self::orderBy('id', 'desc');

        if (isset($input)) {
            $data = $data->when(isset($input['type_category']) && $input['type_category'], function ($query) use ($input) {
                $query->where('type', $input['type_category']);
            })
                ->when(isset($input['name']), function ($query) use ($input) {
                    $query->where('name', 'like', '%' . $input['name'] . '%');
                })
                ->when(isset($input['type']) && $input['type'] != 0, function ($query) use ($input) {
                    $query->where('parent_id', $input['type']);
                });
        }

        return $data->paginate(20);

    }

    public static function getRevenue($input)
    {
        $data = self::with(['customers' => function ($query) use ($input) {
            $query->with(['orders' => function ($query) use ($input) {
                $query->when(isset($input['data_time']), function ($query) use ($input) {
                    $query->when(isset($input['order_id']), function ($query) use ($input) {
                        $query->whereIn('id', $input['order_id']);
                    })
                        ->when($input['data_time'] == 'TODAY' ||
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
                })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                    $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                });
            }]);
        }])
            ->has('customers.orders');

        $data = $data->get();

        $status = [];

        foreach ($data as $item) {
            $revenue = 0;
            if (isset($item->customers)) {
                foreach ($item->customers as $customer) {
                    $revenue += $customer->orders->sum('gross_revenue');
                }
            }
            $status[$item->id]['name'] = $item->name;
            $status[$item->id]['revenue'] = $revenue;
        }

        return $status;
    }

    /**
     * Lấy tổng doanh số danh mục
     *
     * @param $input
     * @param $type
     * @param $paginate
     * @return mixed
     */
    public static function getTotalPrice($input, $type, $paginate)
    {
        $data = self::select('id', 'name')->where('type', $type)->get()->map(function ($item) use ($input) {
            $arr_customer = CustomerGroup::where('category_id', $item->id)->pluck('customer_id')->toArray();
            $order = Order::select('all_total')->whereIn('member_id', $arr_customer)
                ->when(isset($input['data_time']) && $input['data_time'], function ($q) use ($input) {
                    $q->whereBetween('created_at', getTime($input['data_time']));
                })
                ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                    $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                })
                ->with('orderDetails');//doanh so
            $item->all_total = $order->sum('all_total');
            return $item;
        })->sortByDesc('all_total')->take($paginate);
        return $data;
    }
}
