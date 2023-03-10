<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SupportOrder extends Model
{
    protected $guarded = [];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function yTaChinh()
    {
        return $this->belongsTo(User::class, 'yta1_id');
    }

    public function yTaPhu()
    {
        return $this->belongsTo(User::class, 'yta2_id');
    }

    public function tuVanChinh()
    {
        return $this->belongsTo(User::class, 'support1_id');
    }

    public function tuVanPhu()
    {
        return $this->belongsTo(User::class, 'support2_id');
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
