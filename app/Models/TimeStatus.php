<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeStatus extends Model
{
    protected $guarded = [];
    protected $table = 'time_status';

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function statusNext()
    {
        return $this->belongsTo(Status::class,'status_id_next','id');
    }
}
