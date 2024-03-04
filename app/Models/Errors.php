<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Errors extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public const POSITION = 1;
    public const CLASSIFY = 2;
    public const ERROR = 3;
    public const BLOCK = 4;

    public const labelType = [
        self::POSITION => 'Vị trí lỗi',
        self::CLASSIFY => 'Quy trình',
        self::ERROR => 'Phân loại lỗi',
        self::BLOCK => 'Khối',
    ];
}
