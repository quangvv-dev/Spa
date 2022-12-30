<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class HistoryWork extends Model
{
    protected $guarded = [];

    public function status_old()
    {
        return $this->belongsTo(Status::class, 'status_old');
    }

    public function status_new()
    {
        return $this->belongsTo(Status::class, 'status_new');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
