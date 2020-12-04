<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $guarded = ['id'];
    protected $table = 'commissions';
    public $timestamps = 'true';

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function search($input)
    {
        $data = self::orderBy('id', 'desc')->when($input['data_time'] == 'THIS_WEEK' ||
            $input['data_time'] == 'LAST_WEEK' ||
            $input['data_time'] == 'THIS_MONTH' ||
            $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
            $q->whereBetween('created_at', getTime(($input['data_time'])));
        })
            ->when(isset($input['user_id']), function ($query) use ($input) {
                $query->where('user_id', $input['user_id']);
            });
        return $data;
    }
}
