<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'name_machine', 'name_machine');
    }
}
