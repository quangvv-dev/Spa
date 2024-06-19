<?php

namespace App\Services;

use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Models\CallCenter;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\User;
use App\Constants\DepartmentConstant;
use App\Helpers\Functions;
use Illuminate\Support\Facades\DB;

class CskhService
{
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * Công việc của cskh
     *
     * @param $input
     *
     * @return mixed
     */
    public function getDataTask($input)
    {
        return $this->users->join('tasks as t', 't.user_id', '=', 'users.id')
            ->whereBetween('t.date_from', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->where('users.department_id', DepartmentConstant::CSKH)->where('users.active', StatusCode::ON)
            ->groupBy('users.id')
            ->select('users.id')
            ->addSelect(\DB::raw('SUM(CASE WHEN t.task_status_id = "' . StatusConstant::TASK_TODO . '" THEN 1 ELSE 0 END) AS task_todo'))
            ->addSelect(\DB::raw('SUM(CASE WHEN t.task_status_id = "' . StatusConstant::TASK_FAILED . '" THEN 1 ELSE 0 END) AS task_failed'))
            ->addSelect(\DB::raw('SUM(CASE WHEN t.task_status_id = "' . StatusConstant::TASK_DONE . '" THEN 1 ELSE 0 END) AS task_done'))
            ->get();
    }

    /**
     * Đơn hàng của cskh
     *
     * @param $input
     *
     * @return mixed
     */
    public function getDataOrders($input)
    {
        return $this->users->join('orders as o', 'o.cskh_id', '=', 'users.id')
            ->whereBetween('o.created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('o.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('o.branch_id', $input['group_branch']);
            })->whereNull('o.deleted_at')
            ->whereIn('o.role_type', [StatusCode::COMBOS, StatusCode::SERVICE])
            ->where('users.department_id', DepartmentConstant::CSKH)->where('users.active', StatusCode::ON)
            ->groupBy('users.id')
            ->select('users.id')
            ->addSelect(\DB::raw('SUM(CASE WHEN o.is_upsale = "' . StatusCode::ON . '" THEN 1 ELSE 0 END) AS order_upsale'))
            ->addSelect(\DB::raw('SUM(CASE WHEN o.is_upsale = "' . StatusCode::OFF . '" THEN 1 ELSE 0 END) AS order_new'))
            ->get();
    }

    /**
     * SĐT mới
     *
     * @param $input
     *
     * @return mixed
     */
    public function getDataNew($input)
    {
        return $this->users->join('customers as c', 'c.cskh_id', '=', 'users.id')
            ->whereBetween('c.created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('c.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('c.branch_id', $input['group_branch']);
            })->whereNull('c.deleted_at')->where('users.department_id', DepartmentConstant::CSKH)->where('users.active',
                StatusCode::ON)
            ->select('users.id', \DB::raw('COUNT(c.id) as phoneReceive'))
            ->addSelect(\DB::raw('SUM(CASE WHEN c.mkt_id = users.id THEN 1 ELSE 0 END) AS phoneNew'))
//            ->addSelect(\DB::raw('SUM(CASE WHEN c.time_move_cskh >= "' . Functions::yearMonthDay($input['start_date']) . " 00:00:00" . '" and c.time_move_cskh <= "' . Functions::yearMonthDay($input['end_date']) . " 00:00:00" . '" THEN 1 ELSE 0 END) AS phoneReceive'))
            ->groupBy('users.id')
            ->get();
    }

    /**
     * Thực thu cskh
     *
     * @param $input
     *
     * @return mixed
     */
    public function getDataPayment($input)
    {
        return PaymentHistory::join('orders as o', 'payment_histories.order_id', '=', 'o.id')
            ->join('users as u', 'o.cskh_id', '=', 'u.id')
            ->whereBetween('payment_histories.payment_date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('payment_histories.branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('payment_histories.branch_id', $input['group_branch']);
            })
            ->where('u.department_id', DepartmentConstant::CSKH)->where('u.active', StatusCode::ON)
            ->select('u.id', DB::raw('SUM(payment_histories.price) as all_payment'))
            ->addSelect(\DB::raw('SUM(CASE WHEN o.is_upsale = "' . StatusCode::ON . '" THEN payment_histories.price ELSE 0 END) AS payment_upsale'))
            ->addSelect(\DB::raw('SUM(CASE WHEN o.is_upsale = "' . StatusCode::OFF . '" THEN payment_histories.price ELSE 0 END) AS payment_new'))
            ->groupBy('u.id')->get();
    }

    public function getDataCall($input)
    {
        return $this->users->join('call_center as cc', 'cc.caller_number', '=', 'users.caller_number')
            ->whereBetween('cc.start_time', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
//            ->where('cc.call_status', CallCenter::ANSWERED)
            ->where('users.department_id', DepartmentConstant::CSKH)->where('users.active', StatusCode::ON)
            ->select('users.id','cc.answer_time')
            ->addSelect(\DB::raw('SUM(CASE WHEN cc.call_status = "ANSWERED" THEN cc.answer_time ELSE 0 END) AS minute'))
            ->addSelect(\DB::raw('SUM(CASE WHEN cc.call_status = "ANSWERED" THEN 1 ELSE 0 END) AS answers'))
            ->addSelect(\DB::raw('SUM(CASE WHEN cc.call_status = "MISSED CALL" THEN 1 ELSE 0 END) AS missed_call'))
            ->groupBy('users.id')->get();
    }

    /**
     * Transform data output
     *
     * @param $task
     * @param $orders
     * @param $data
     * @param $payments
     *
     * @return mixed
     */
    public function transformData($tasks, $orders, $data, $payments, $call = null, $members = [])
    {
        $users = User::select('id', 'full_name', 'avatar')
            ->when(count($members), function ($q) use ($members) {
                $q->whereIn('id', $members);
            })
            ->where('users.department_id', DepartmentConstant::CSKH)
            ->where('active', StatusCode::ON)->get();
        return $users->transform(function ($item) use ($tasks, $orders, $data, $payments, $call) {
            return [
                'id'             => $item->id,
                'full_name'      => $item->full_name,
                'avatar'         => @$item->avatar,
                'task_todo'      => @$tasks->firstWhere('id', $item->id)->task_todo ?? 0,
                'task_failed'    => @$tasks->firstWhere('id', $item->id)->task_failed ?? 0,
                'task_done'      => @$tasks->firstWhere('id', $item->id)->task_done ?? 0,
                'missed_call'           => !empty($call) ? @$call->firstWhere('id', $item->id)->missed_call ?? 0 : 0,
                'answers'        => !empty($call) ? @$call->firstWhere('id', $item->id)->answers ?? 0 : 0,
                'minute'         => !empty($call) ? @$call->firstWhere('id', $item->id)->minute ?? 0 : 0,
                'phoneNew'       => @$data->firstWhere('id', $item->id)->phoneNew ?? 0,
                'phoneReceive'   => @$data->firstWhere('id', $item->id)->phoneReceive ?? 0,
                'order_upsale'   => @$orders->firstWhere('id', $item->id)->order_upsale ?? 0,
                'order_new'      => @$orders->firstWhere('id', $item->id)->order_new ?? 0,
                'payment_upsale' => @$payments->firstWhere('id', $item->id)->payment_upsale ?? 0,
                'payment_new'    => @$payments->firstWhere('id', $item->id)->payment_new ?? 0,
                'all_payment'    => @$payments->firstWhere('id', $item->id)->all_payment ?? 0,
            ];
        });
    }


}
