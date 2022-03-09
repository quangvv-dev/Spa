<?php

namespace App\Models;

use App\Constants\StatusCode;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['id'];
    protected $table = 'branchs';

    public static $location = [
        StatusCode::CUM_MIEN_BAC    => 'Cụm Miền Bắc',
//        StatusCode::CUM_MIEN_TRUNG  => 'Cụm Miền Trung',
        StatusCode::CUM_MIEN_NAM    => 'Cụm Miền Nam'
    ];

    public static function search()
    {
        $data = self::get();
        return $data;
    }
}
