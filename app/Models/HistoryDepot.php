<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Functions;

class HistoryDepot extends Model
{
    protected $guarded = [];

    public static function search($input)
    {
        $data = self::when(!empty($input['branch_id']), function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(!empty($input['status']), function ($q) use ($input) {
            $q->where('status', $input['status']);
        })->when(!empty($input['product_id']), function ($q) use ($input) {
            $q->where('product_id', $input['product_id']);
        })->when(!empty($input['code_order']), function ($q) use ($input) {
            $q->where('code_order', $input['code_order']);
        })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDayTime($input['start_date']),
                    Functions::yearMonthDayTime($input['end_date']),
                ]);
            })->orderByDesc('id');

        return $data;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function product()
    {
        return $this->belongsTo(Services::class, 'product_id');
    }

}
