<?php

namespace App\Models;

use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $guarded = ['id'];
    protected $table = 'commissions';
    public $timestamps = 'true';

    public function orders()
    {
        return $this->belongsTo(WalletHistory::class, 'order_id', 'id');
    }
    public function supportOrder()
    {
        return $this->belongsTo(SupportOrder::class, 'order_id', 'order_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function search($input, $select = '*')
    {
        $data = self::select($select)
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereHas('orders',function ($qr) use ($input){
                    $qr->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                });
            })
            ->when(isset($input['user_id']), function ($query) use ($input) {
                $query->where('user_id', $input['user_id']);
            });
        return $data->orderByDesc('id');
    }
}
