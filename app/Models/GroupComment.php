<?php

namespace App\Models;

use App\User;
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
}
