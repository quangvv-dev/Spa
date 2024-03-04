<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Errors extends Model
{
    protected $fillable = ['name', 'type'];
    public $timestamps = false;

    public const POSITION = 1;
    public const CLASSIFY = 2;
    public const ERROR = 3;
    public const BLOCK = 4;

    public const labelType = [
        self::POSITION => 'Vị trí',
        self::CLASSIFY => 'Quy trình',
        self::ERROR => 'Lỗi',
        self::BLOCK => 'Khối',
    ];
}
