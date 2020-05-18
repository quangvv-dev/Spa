<?php

namespace App\Models;

use App\Helpers\Functions;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GroupComment extends Model
{
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getAll($input)
    {
//        $data = self::with('user');

//        if (isset($input)) {
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
            })
            ->when(isset($input['user_id']), function ($query) use($input) {
               $query->where('user_id', $input['user_id']);
            })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date'])." 00:00:00", Functions::yearMonthDay($input['end_date'])." 23:59:59"]);
            });
//        }

        $data = $data->count();

        return $data;
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('H:i d-m-Y');
    }
}
