<?php

namespace App\Models;

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
}
