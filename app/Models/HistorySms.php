<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Functions;

class HistorySms extends Model
{
    protected $guarded = ['id'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id')->withTrashed();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'phone', 'phone')->withTrashed();
    }

    public static function search($input)
    {
        $data = self::when(isset($input['campaign_id']) && $input['campaign_id'], function ($query) use ($input) {
            $query->where('campaign_id', $input['campaign_id']);
        })->when(isset($input['data_time']), function ($query) use ($input) {
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
            })->orderByDesc('created_at');

        return $data;
    }
}
