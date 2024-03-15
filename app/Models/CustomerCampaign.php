<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCampaign extends Model
{
    protected $guarded = ['id'];
    protected $table = 'customer_campaign';
    public $timestamps = false;
}
