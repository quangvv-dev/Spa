<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = ['id'];
    protected $table = 'status';
    public $timestamps = true;

    public function customers()
    {
        return $this->hasMany(Customer::class, 'status_id', 'id');
    }

    public function customerSources()
    {
        return $this->hasMany(Customer::class, 'source_id', 'id');
    }

    public static function getRelationship($input = null)
    {
        $data = self::with('customers.orders')
            ->where('type', StatusCode::RELATIONSHIP);

        if (isset($input)) {
            $data = $data->when(isset($input['data_time']), function ($query) use ($input) {
                $query->whereHas('customers', function ($query) use ($input) {
                    $query->whereHas('orders', function ($query) use ($input) {
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
                });
            });
        }

        $data = $data->get();

        return $data;
    }


    public static function getRevenueSource($input)
    {
        $data = self::with('customerSources.orders')
            ->has('customerSources.orders')
            ->where('type', StatusCode::SOURCE_CUSTOMER);

        if (isset($input)) {
            $data = $data->when(isset($input['data_time']), function ($query) use ($input) {
                $query->whereHas('customerSources', function ($query) use ($input) {
                    $query->whereHas('orders', function ($query) use ($input) {
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
                });
            })
            ->when(isset($input['user_id']), function ($query) use ($input) {
                $query->whereHas('customerSources', function ($q) use ($input) {
                    $q->where('mkt_id', $input['user_id']);
                });
            });
        }

        $data = $data->get();
        return OrderService::handleData($data);
    }

    public static function getRevenueSourceByRelation($input)
    {
        $data = self::with('customers.orders')->has('customers.orders')
            ->where('type', StatusCode::RELATIONSHIP);

        if (isset($input)) {
            $data = $data->when(isset($input['data_time']), function ($query) use ($input) {
                $query->whereHas('customers', function ($query) use ($input) {
                    $query->whereHas('orders', function ($query) use ($input) {
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
                })
                ->when(isset($input['user_id']), function ($query) use ($input) {
                    $query->whereHas('customers', function ($q) use ($input) {
                        $q->where('mkt_id', $input['user_id']);
                    });
                });
            });
        }

        $data = $data->get();

        $status = [];

        foreach ($data as $item) {
            if (!empty($item->customers)) {
                $price = 0;

                foreach ($item->customers as $customer) {
                    if (!empty($customer->orders)) {
                        $price += $customer->orders->sum('gross_revenue');
                    }
                }

                $status[$item->id]['name'] = $item->name;
                $status[$item->id]['revenue'] = $price;
            }
        }

        return $status;
    }
}
