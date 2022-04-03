<?php

namespace App\Models;

use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class PriceMarketing extends Model
{
    protected $guarded = ['id'];
    protected $table = 'price_marketings';

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function search($input)
    {
        $data = self::orderBy('id', 'desc')->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        })->when(isset($input['source_id']), function ($query) use ($input) {
            $query->where('source_id', $input['source_id']);
        })->when(isset($input['user_id']), function ($query) use ($input) {
            $query->where('user_id', $input['user_id']);
        })->when(isset($input['branch_id']), function ($query) use ($input) {
                $query->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        });

        return $data;
    }
}
