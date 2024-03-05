<?php

namespace App\Models;

use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $guarded = [];

    public const PENDING = 0;
    public const ACTIVE = 1;
    public const INACTIVE = 2;

    public const labelStatus = [
        self::PENDING => 'Chờ xử lý',
        self::ACTIVE => 'Duyệt',
        self::INACTIVE => 'Không duyệt',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Errors::class);
    }

    public function classify()
    {
        return $this->belongsTo(Errors::class);
    }

    public function block()
    {
        return $this->belongsTo(Errors::class);
    }

    public function error()
    {
        return $this->belongsTo(Errors::class);
    }

    public static function search($input)
    {
        return self::when(isset($input['owner_id']) && $input['owner_id'], function ($q) use ($input) {
            $q->where('owner_id', $input['owner_id']);
        })->when(isset($input['position_id']) && $input['position_id'], function ($q) use ($input) {
            $q->where('position_id', $input['position_id']);
        })->when(isset($input['classify_id']) && $input['classify_id'], function ($q) use ($input) {
            $q->where('classify_id', $input['classify_id']);
        })->when(isset($input['error_id']) && $input['error_id'], function ($q) use ($input) {
            $q->where('error_id', $input['error_id']);
        })->when(isset($input['block_id']) && $input['block_id'], function ($q) use ($input) {
            $q->where('block_id', $input['block_id']);
        })->when(isset($input['user_id']) && $input['user_id'], function ($q) use ($input) {
            $q->where('user_id', $input['user_id']);
        })->when(isset($input['status']) && $input['status'], function ($q) use ($input) {
            $q->where('status', $input['status']);
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('date_check', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        })->orderByDesc('id');
    }
}
