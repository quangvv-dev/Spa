<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = ['id'];
    protected $table = 'status';
    public $timestamps = false;

    public function customers()
    {
        return $this->hasMany(Customer::class, 'status_id', 'id');
    }

    public static function getRelationship()
    {
        return self::with('customers.orders')->where('type', StatusCode::RELATIONSHIP)->get();
    }


    public static function getRevenueSource()
    {
        $data = self::with('customers.orders')
            ->has('customers.orders')
            ->where('type', StatusCode::SOURCE_CUSTOMER)
            ->get();

        return OrderService::handleData($data);
    }

    public static function getRevenueSourceByRelation()
    {
        $data = self::with('customers.orders')->has('customers.orders')
            ->where('type', StatusCode::RELATIONSHIP)
            ->get();

        $status = [];
        $revenue = 0;

        foreach ($data as $item) {
            if (!empty($item->customers)) {
                $status[$item->id]['name'] = $item->name;
                foreach ($item->customers as $customer) {
                    if (!empty($customer->orders)) {
                        $revenue += $customer->orders->sum('all_total');
                    }
                }
                $status[$item->id]['revenue'] = $revenue;
            }
        }

        return $status;
    }
}
