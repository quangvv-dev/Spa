<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['id'];
    protected $table = 'branchs';

    public static function search()
    {
        $data = self::get();
        return $data;
    }

    public static function getLocation()
    {
        return \App\Models\Location::get()->pluck('name', 'id');
    }
}
