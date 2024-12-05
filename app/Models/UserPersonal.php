<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserPersonal extends Model
{
    protected $guarded = ['id'];
    protected $table = 'user_personal';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leave_reason()
    {
        return $this->belongsTo(LeaveReason::class);
    }
}
