<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $fillable = ['title','type','value','color','parent_id','additional_settings'];
}
