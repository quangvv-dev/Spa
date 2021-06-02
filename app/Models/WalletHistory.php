<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Functions;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletHistory extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    public function package()
    {
        return $this->belongsTo(PackageWallet::class, 'package_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function search($input)
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
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
        });
        return $data;
    }
}
