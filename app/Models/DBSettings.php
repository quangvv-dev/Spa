<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DBSettings extends Model
{
    protected $table = 'settings';
    protected $primaryKey ="setting_key";
    protected $guarded = ['setting_value'];
    public $timestamps = false;
}
