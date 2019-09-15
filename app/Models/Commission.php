<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $guarded = ['id'];
    protected $table = 'commissions';

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
