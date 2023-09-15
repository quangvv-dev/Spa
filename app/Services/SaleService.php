<?php

namespace App\Services;

use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Models\CallCenter;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\User;
use App\Constants\DepartmentConstant;
use App\Helpers\Functions;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    public function getDataNew($input)
    {
        return $this->users->join('customers as c', 'c.telesales_id', '=', 'users.id')
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
        return $this->users->join('customers as c', 'c.telesales_id', '=', 'users.id')
            ->join('orders as o', 'o.member_id', '=', 'c.id')
            ->whereBetween('o.created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('o.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('o.branch_id', $input['group_branch']);
            })->whereNull('o.deleted_at')->whereNull('c.deleted_at')
            ->where('o.is_upsale', OrderConstant::NON_UPSALE)
            ->whereIn('o.role_type', [StatusCode::COMBOS, StatusCode::SERVICE])
            ->where('users.department_id', DepartmentConstant::TELESALES)
            ->select('users.id', 'users.full_name', \DB::raw('COUNT(o.id) as orderNew'),
                \DB::raw('SUM(o.gross_revenue) as gross_revenue'))
            ->groupBy('users.id')
            ->get();
    }

    public function getDataSchedules($input)
    {
        return $this->users->leftJoin('schedules as s', 's.creator_id', '=', 'users.id')
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
            ->addSelect(\DB::raw('SUM(CASE WHEN s.status = "' . ScheduleConstant::DEN_MUA . '" THEN 1 ELSE 0 END) AS schedules_mua'))
            ->addSelect(\DB::raw('SUM(CASE WHEN s.status = "' . ScheduleConstant::CHUA_MUA . '" THEN 1 ELSE 0 END) AS schedules_failed'))
            ->groupBy('users.id')
            ->get();
    }

    public function getDataPayment($input)
    {
        return PaymentHistory::join('orders as o', 'payment_histories.order_id', '=', 'o.id')
            ->join('customers as c', 'c.id', '=', 'o.member_id')
            ->leftJoin('users as u', 'c.telesales_id', '=', 'u.id')
            ->whereBetween('payment_histories.payment_date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('payment_histories.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('payment_histories.branch_id', $input['group_branch']);
            })
            ->where('o.is_upsale', OrderConstant::NON_UPSALE)
            ->where('u.department_id', DepartmentConstant::TELESALES)->where('u.active', StatusCode::ON)
            ->select('u.id', DB::raw('SUM(payment_histories.price) as totalNew'))
            ->addSelect(\DB::raw('SUM(CASE WHEN payment_histories.is_debt = "' . StatusCode::ON . '" THEN payment_histories.price ELSE 0 END) AS the_rest'))
            ->groupBy('u.id')->get();
    }

    public function getDataCall($input)
    {
        return $this->users->join('call_center as cc', 'cc.caller_number', '=', 'users.caller_number')
            ->whereBetween('cc.start_time', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->where('cc.call_status', CallCenter::ANSWERED)
            ->where('users.department_id', DepartmentConstant::TELESALES)->where('users.active', StatusCode::ON)
            ->select('users.id', DB::raw('COUNT(cc.id) as total'))
            ->groupBy('users.id')->get();
    }

    public function transformData($data_new, $order_new, $schedules, $payments, $call)
    {
        $users = User::select('id', 'full_name', 'avatar')->where('users.department_id', DepartmentConstant::TELESALES)
            ->where('active', StatusCode::ON)->get();
        return $users->transform(function ($item) use ($data_new, $order_new, $schedules, $payments, $call) {
            $result = [
                'id'               => $item->id,
                'full_name'        => $item->full_name,
                'avatar'           => @$item->avatar,
                'phoneNew'         => @$data_new->firstWhere('id',$item->id)->phoneNew??0,
                'orderNew'         => @$order_new->firstWhere('id',$item->id)->orderNew??0,
                'schedulesNew'     => @$schedules->firstWhere('id',$item->id)->schedulesNew??0,
                'schedules_mua'    => !empty($schedules->firstWhere('id',$item->id)->schedules_mua)?(int)$schedules->firstWhere('id',$item->id)->schedules_mua:0,
                'schedules_failed' => !empty($schedules->firstWhere('id',$item->id)->schedules_failed)?(int)$schedules->firstWhere('id',$item->id)->schedules_failed:0,
                'gross_revenue'    => @$order_new->firstWhere('id',$item->id)->gross_revenue??0,
                'call'             => @$call->firstWhere('id',$item->id)->total??0,
                'totalNew'         => @$payments->firstWhere('id',$item->id)->totalNew??0,
                'the_rest'         => @!empty($payments->firstWhere('id',$item->id)->the_rest)?(int)$payments->firstWhere('id',$item->id)->the_rest:0,
            ];
            $result['percentOrder'] = (int)$result['phoneNew']>0 ? round($result['orderNew'] / $result['phoneNew'] * 100, 2) : 0;
            $result['avg'] = (int)$result['orderNew'] > 0  ? round((int)$result['totalNew'] / (int)$result['orderNew'] * 100, 2) : 0;
            return $result;
        });
    }


}
