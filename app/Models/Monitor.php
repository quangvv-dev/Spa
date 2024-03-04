<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Errors::class);
    }

    public function classify()
    {
        return $this->belongsTo(Errors::class);
    }

    public function block()
    {
        return $this->belongsTo(Errors::class);
    }

    public function error()
    {
        return $this->belongsTo(Errors::class);
    }
}
