<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'booking_id', 'id');
    }

    public static function getAll()
    {
        return self::get();
    }
}
