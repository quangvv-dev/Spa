<?php

namespace App\Services;

use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Models\Product;
use App\User;
use App\Constants\DepartmentConstant;
use App\Helpers\Functions;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getDataNew($input)
    {
        return $this->user->join('customers as c', 'c.telesales_id', '=', 'users.id')
            ->whereBetween('c.created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('c.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('c.branch_id', $input['group_branch']);
            })->whereNull('c.deleted_at')->where('users.department_id', DepartmentConstant::TELESALES)
            ->select('users.id', \DB::raw('COUNT(c.id) as phoneNew'))->groupBy('users.id')
            ->get();
    }

    public function getDataOrders($input)
    {
        return $this->user->join('customers as c', 'c.telesales_id', '=', 'users.id')
            ->join('orders as o', 'o.member_id', '=', 'c.id')
            ->whereBetween('o.created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('o.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('o.branch_id', $input['group_branch']);
            })->whereNull('o.deleted_at')->whereNull('c.deleted_at')->where('o.is_upsale', OrderConstant::NON_UPSALE)
            ->where('users.department_id', DepartmentConstant::TELESALES)
            ->select('users.id', \DB::raw('COUNT(o.id) as orderNew'),
                \DB::raw('SUM(o.gross_revenue) as gross_revenue'))
            ->groupBy('users.id')
            ->get();
    }

    public function getDataSchedules($input)
    {
        return $this->user->leftJoin('schedules as s', 's.creator_id', '=', 'users.id')
            ->leftJoin('customers as c', 's.user_id', '=', 'c.id')
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('s.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('s.branch_id', $input['group_branch']);
            })
            ->where('c.old_customer', 0)
            ->whereNull('c.deleted_at')
            ->where('users.department_id', DepartmentConstant::TELESALES)->where('users.active', StatusCode::ON)

//            ->whereRaw(DB::raw("COALESCE(s.date, '2022-08-01') >= '2022-08-01' AND COALESCE(s.date, '2022-08-30') <= '2022-08-30'"))
            ->whereBetween('s.date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->select('users.id', \DB::raw('COUNT(s.id) as schedulesNew'))
            ->addSelect(\DB::raw('SUM(CASE WHEN s.status = "'.ScheduleConstant::DEN_MUA.'" THEN 1 ELSE 0 END) AS schedules_mua'))
            ->addSelect(\DB::raw('SUM(CASE WHEN s.status = "'.ScheduleConstant::CHUA_MUA.'" THEN 1 ELSE 0 END) AS schedules_failed'))
            ->groupBy('users.id')
            ->get();

    }


}
