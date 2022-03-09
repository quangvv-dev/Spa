<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Functions;
use App\Constants\StatusCode;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $guarded = ['id'];
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'booking_id', 'id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public static function getAll()
    {
        return self::get();
    }

    public static function getCustomerSearch($input)
    {
        $data = self::when(isset($input['data_time']), function ($query) use ($input) {
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
        })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            })->get();
        $response = [];
        foreach ($data as $item) {
            $name = Status::getStatusWithId($item->user->source_id);
            if ($name) {
                $response[$name][] = (int)$item->total_price;
            }
        }
        return $response;
    }

    public static function search($input, $select = '*')
    {
        $data = self::select($select)->when(isset($input['data_time']), function ($query) use ($input) {
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
        })->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })
        ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            })->when(isset($input['booking_id']), function ($query) use ($input) {
                $query->whereIn('booking_id', $input['booking_id']);
            })
            ->when(isset($input['list_booking']) && count($input['list_booking']), function ($query) use ($input) {
                $query->whereIn('booking_id', $input['list_booking']);
            });
        return $data;
    }

    /**
     * lấy ra tổng doanh số của sản phẩm
     *
     * @param $input
     * @param $paginate
     * @return mixed
     */
    public static function getTotalPriceBookingId($input, $type, $paginate)
    {
        $data = self::select('booking_id', \DB::raw('SUM(total_price) AS total'))->groupBy('booking_id')
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })
            ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            })->when(isset($input['data_time']) && $input['data_time'], function ($q) use ($input) {
                $q->whereBetween('created_at', getTime($input['data_time']));
            })
            ->whereHas('service')->get()->map(function ($item) use ($type) {
                if (isset($item->service) && $item->service->type == $type) {
                    return $item;
                }
            })
            ->sortByDesc('total')->take($paginate);
        return $data;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
