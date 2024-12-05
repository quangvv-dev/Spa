<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryStatus extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
