<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = ['id'];
    protected $table = 'status';
    public $timestamps = false;

    public function customers()
    {
        return $this->hasMany(Customer::class, 'status_id', 'id');
    }
}
