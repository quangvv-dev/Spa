<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = ['id'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
