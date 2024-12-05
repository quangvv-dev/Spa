<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = ['id'];
    protected $table = 'notifications';
    
    public function getDataAttribute($data)
    {
        return @json_decode($data, true);
    }

    public function setDataAttribute($data)
    {
        return @json_encode($data, true);
    }

}
