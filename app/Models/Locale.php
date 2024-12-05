<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $guarded = ['id'];
    protected $table = 'locales';
}
