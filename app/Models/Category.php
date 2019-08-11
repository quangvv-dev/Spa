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

    public static function getRevenue()
    {
        $data = self::with('customers.orders')
            ->has('customers.orders')
            ->get();

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
