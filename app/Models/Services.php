<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Constants\UserConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    protected $guarded = ['id'];
    protected $table = 'services';
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function trademarks()
    {
        return $this->belongsTo(Trademark::class, 'trademark')->withTrashed();
    }

    public function getActiveTextAttribute()
    {
        return $this->enable == UserConstant::ACTIVE ? 'Hoạt động' : 'Ngừng hoạt động';
    }

    public function orders()
    {
        return $this->hasMany(OrderDetail::class, 'booking_id', 'id');
    }

    public function getImagesAttribute($images)
    {
        return @json_decode($images, true);
    }

    public static function getIdServiceType()
    {
        $data = self::pluck('id')->toArray();
        return $data;
    }

    public static function handleChart($arr=null, $input = [])
    {
        $data = OrderDetail::select('*',DB::raw("SUM(total_price) as count"),DB::raw("count(order_id) as count_order"))
            ->groupBy('booking_id')
            ->when(isset($arr) && $arr, function ($q) use ($arr) {
                $q->whereIn('booking_id', $arr);
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
            });

        return $data;
    }
}
