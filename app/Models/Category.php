<?php

namespace App\Models;

use App\Services\OrderService;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $table = 'categories';

    public function categories()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'group_id', 'id');
    }

    public static function getRevenue($input)
    {
        $data = self::with('customers.orders')
            ->has('customers.orders');

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

        $data = $data->get();

        $status = [];
        $revenue = 0;

        foreach ($data as $item) {
            if (isset($item->customers)) {
                $status[$item->id]['name'] = $item->name;
                foreach ($item->customers as $customer) {
                    $revenue += $customer->orders->sum('all_total');
                }
            }
            $status[$item->id]['revenue'] = $revenue;
        }

        return $status;
    }
}
