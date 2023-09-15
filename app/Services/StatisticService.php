<?php


namespace App\Services;

use App\Components\Filesystem\Filesystem;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Order;
use App\User;
use Illuminate\Support\Facades\DB;

class StatisticService
{

    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    public function getRoleOrderNumber($input)
    {
        return $this->orders->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        })->whereBetween('created_at', [
            Functions::yearMonthDay($input['start_date']) . " 00:00:00",
            Functions::yearMonthDay($input['end_date']) . " 23:59:59",
        ])->select(DB::raw('SUM(CASE WHEN all_total >= 1000000 THEN 1 ELSE 0 END) AS lieu_trinh'))
            ->addSelect(DB::raw('SUM(CASE WHEN all_total < 1000000 THEN 1 ELSE 0 END) AS don_le'))
            ->get();
    }

}
