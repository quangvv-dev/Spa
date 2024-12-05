<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    protected $guarded = [];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'name_machine', 'name_machine');
    }
    public function user(){
        return $this->belongsTo(User::class,'approval_code','approval_code');
    }
}
