<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalImage extends Model
{
    protected $fillable = ['name', 'link', 'type'];

    public const CCCD_FRONT = 'ẢNH CCCD MẶT TRƯỚC';
    public const CCCD_BEHIND = 'ẢNH CCCD MẶT SAU';
    public const PROBATION = 'FILE HĐ THỬ VIỆC';
    public const WORK_CONTACT = 'FILE HĐ CHÍNH THỨC';
    public const PLUS_SALARY = 'FILE QUYẾT ĐỊNH TĂNG LƯƠNG';
    public const SIRE_WORK = 'FILE QUYẾT ĐỊNH THĂNG CHỨC';
    public const CANCEL_WORK = 'FILE QUYẾT ĐỊNH NGHỈ VIỆC';

    public const NAME_LABEL = [
        self::CCCD_FRONT, self::CCCD_BEHIND,
        self::PROBATION, self::WORK_CONTACT,
        self::PLUS_SALARY, self::SIRE_WORK,
        self::CANCEL_WORK
    ];
}
