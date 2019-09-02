<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    protected $table = 'customer_groups';
    protected $guarded = ['id'];
    public $timestamps = false;
}
