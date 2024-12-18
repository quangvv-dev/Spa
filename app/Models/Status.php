<?php

namespace App\Models;

use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Status extends Model
{
    protected $guarded = ['id'];
    protected $table = 'status';
    public $timestamps = true;

    public function customers()
    {
        if ($this->type == StatusCode::SOURCE_CUSTOMER) {
            return $this->hasMany(Customer::class, 'source_id', 'id');
        } elseif ($this->type == StatusCode::RELATIONSHIP) {
            return $this->hasMany(Customer::class, 'status_id', 'id');
        }
    }

    public function customerSources()
    {
        return $this->hasMany(Customer::class, 'source_id', 'id');
    }

    public static function getRelationship($input = null)
    {
        $data = self::with([
            'customers' => function ($query) use ($input) {
                $query->whereHas('orders', function ($query) use ($input) {
                    $query->when(isset($input['data_time']), function ($query) use ($input) {
                        $query->when($input['data_time'] == 'TODAY' ||
                            $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                            $q->whereDate('orders.created_at', getTime(($input['data_time'])));
                        })
                            ->when($input['data_time'] == 'THIS_WEEK' ||
                                $input['data_time'] == 'LAST_WEEK' ||
                                $input['data_time'] == 'THIS_MONTH' ||
                                $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                                $q->whereBetween('orders.created_at', getTime(($input['data_time'])));
                            });
                    })
                        ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                            $q->whereBetween('created_at', [
                                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                            ]);
                        });
                });
            },
        ])
            ->where('type', StatusCode::RELATIONSHIP);

        $data = $data->get();

        return $data;
    }


    public static function getRelationshipByCustomer($customers)
    {

        $data = self::where('type', StatusCode::RELATIONSHIP)->orderBy('position', 'ASC')->get()->map(function ($item
        ) use ($customers) {
            $caculate = clone $customers;
            $item->customers_count = $caculate->where('status_id', $item->id)->count();
            return $item;
        });

        return $data;
    }

    public static function getRelationshipByCustomerV2($input = [])
    {
        $base = Status::leftJoin('customers as c', 'c.status_id', 'status.id');
        if (!empty($input['group'])) {
            $base = $base->join('customer_groups as cg', 'c.id', 'cg.customer_id')
                ->where('cg.category_id', $input['group']);
        }
        $data = $base->where('status.type', StatusCode::RELATIONSHIP)
            ->select('status.id', 'status.name', 'status.color', DB::raw('COUNT(c.id) as customers_count'))
            ->when(isset($input['branch_id']), function ($query) use ($input) {
                $query->where('c.branch_id', $input['branch_id']);
            })->when(isset($input['telesales']), function ($query) use ($input) {
                $query->where('c.telesales_id', $input['telesales']);
            })->when(isset($input['marketing']), function ($query) use ($input) {
                $query->where('c.mkt_id', $input['marketing']);
            })->when(isset($input['source']), function ($query) use ($input) {
                $query->where('c.source_id', $input['source']);
            })->when(isset($input['data_time']) && $input['data_time'], function ($query) use ($input) {
                $query->when($input['data_time'] == 'TODAY' ||
                    $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                    $q->whereDate('c.created_at', getTime(($input['data_time'])));
                })->when($input['data_time'] == 'THIS_WEEK' ||
                    $input['data_time'] == 'LAST_WEEK' ||
                    $input['data_time'] == 'THIS_MONTH' ||
                    $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                    $q->whereBetween('c.created_at', getTime(($input['data_time'])));
                });
            })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('c.created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            })
            ->orderBy('status.position', 'ASC')->groupBy('status.id')->get();

        return $data;
    }

    public static function getRevenueSource($input)
    {
        $data = self::with([
            'customerSources' => function ($query) use ($input) {
                $query->with([
                    'order_detail' => function ($query) use ($input) {
                        $query->when(isset($input['list_booking']) && count($input['list_booking']),
                            function ($query) use ($input) {
                                $query->whereIn('booking_id', $input['list_booking']);
                            })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                            $q->where('branch_id', $input['branch_id']);
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
                            ->when(isset($input['start_date']) && isset($input['end_date']),
                                function ($q) use ($input) {
                                    $q->whereBetween('created_at', [
                                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                                    ]);
                                });
                    },
                ]);
            },
        ])
            ->where('type', StatusCode::SOURCE_CUSTOMER);

        $data = $data->get();
        return OrderService::handleData($data);
    }

    public static function getRevenueSourceByRelation($input)
    {
        $data = self::with([
            'customers' => function ($query) use ($input) {
                $query->with([
                    'orders' => function ($query) use ($input) {
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
                        })
                            ->when(isset($input['start_date']) && isset($input['end_date']),
                                function ($q) use ($input) {
                                    $q->whereBetween('created_at', [
                                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                                    ]);
                                });
                    },
                ]);
            },
        ])
            ->where('type', StatusCode::RELATIONSHIP);

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

    public static function getStatusWithId($id)
    {
        $data = self::select('name')->find($id);
        return $data ? $data->name : [];
    }
}
