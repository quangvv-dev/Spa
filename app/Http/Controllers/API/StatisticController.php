<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\CategoryRevenueResource;
use App\Http\Resources\SchedulesResource;
use App\Http\Resources\TasksResource;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Task;
use App\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\Functions;
use App\Constants\UserConstant;

class StatisticController extends BaseApiController
{
    private $customer;

    /**
     * StatisticController constructor.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $user = User::get()->pluck('full_name', 'id')->toArray();
        $this->customer = $customer;
        view()->share([
            'user' => $user,
        ]);
    }


    /**
     * Lịch hẹn
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function schedules(Request $request)
    {
        $input = $request->all();
        $users = User::select('id', 'full_name')
            ->whereIn('role',
                [UserConstant::TELESALES, UserConstant::WAITER, UserConstant::CSKH, UserConstant::TP_CSKH])
            ->get()->map(function ($item) use ($input) {
                $schedule = Schedule::where('person_action', $item->id)->whereBetween('date', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
                $schedule2 = clone $schedule;
                $schedule3 = clone $schedule;

                $item->all_schedules = $schedule->count();
                $item->schedules_buy = $schedule->where('status', 3)->count();
                $item->schedules_notbuy = $schedule2->where('status', 4)->count();
                $item->schedules_cancel = $schedule3->where('status', 5)->count();
                return $item;
            })->sortByDesc('all_schedules');

        $data = SchedulesResource::collection($users);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Công việc
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tasks(Request $request)
    {
        $input = $request->all();
        $users = User::select('id', 'full_name')
            ->whereIn('role',
                [UserConstant::TELESALES, UserConstant::CSKH, UserConstant::TP_CSKH])
            ->get()->map(function ($item) use ($input) {
                $task = Task::where('user_id', $item->id)->whereBetween('date_from', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
                $task1 = clone $task;
                $item->all_task = $task->count();
                $item->all_done = $task->where('task_status_id', StatusCode::DONE_TASK)->count();
                $item->all_failed = $task1->where('task_status_id', StatusCode::FAILED_TASK)->count();
                return $item;
            })->sortByDesc('all_task');

        $data = TasksResource::collection($users);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Doanh thu theo nhóm
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function group(Request $request)
    {
        $input = $request->all();
        $category = Category::select('id', 'name', 'type')->where('type', $request->type)->get()->map(function ($item
        ) use ($request, $input) {
            $arr_customer = CustomerGroup::where('category_id', $item->id)->pluck('customer_id')->toArray();

            if ($request->telesale_id) {
                $data = Customer::select('id')->whereIn('id', $arr_customer)->where('telesales_id',
                    $request->telesale_id);
                $data = self::searchBranch($data, $request);
            } else {
                $data = Customer::select('id')->whereIn('id', $arr_customer);
                $data = self::searchBranch($data, $request);
            }

            $order = Order::when(!empty($input['start_date']) && !empty($input['end_date']),
                function ($q) use ($input) {
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                })->whereIn('member_id', $data->pluck('id')->toArray())->with('orderDetails');
            $order = self::searchBranch($order, $request);

//            $payment_history = PaymentHistory::when(!empty($input['start_date']) && !empty($input['end_date']),
//                function ($q) use ($input) {
//                    $q->whereBetween('created_at', [
//                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
//                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
//                    ]);
//                })->whereIn('order_id', $order->pluck('id')->toArray());
//            $payment_history = self::searchBranch($payment_history, $request);

            $item->orders = $order->count();
            $item->revuenue = $order->sum('gross_revenue');//da thu trong ky thu thêm
            $item->total = $order->sum('all_total');//da thu trong ky thu thêm
            return $item;
        })->sortByDesc('revuenue');
        $data = CategoryRevenueResource::collection($category);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function groupDetail(Request $request, $id)
    {
        $input = $request->all();

        $category = Category::find($id);
        $arr_customer = CustomerGroup::where('category_id', $category->id)->pluck('customer_id')->toArray();

        $customer = Customer::select('id')->whereIn('id', $arr_customer);
        $data_new = self::searchDateBranch($customer, $input);

        $ordersAll = Order::returnRawData($input);
        $orders_new = $ordersAll->whereIn('member_id', $data_new)->with('orderDetails');

        $schedules_new = Schedule::select('id')->whereIn('user_id', $data_new->pluck('id')->toArray());
        $schedules_new = self::searchDateBranch($schedules_new, $input);


        $data = [
            'phone' => $data_new->count(),
            'schedules_new' => $schedules_new->count(),
            'order_old' => 0,
            'total_old' => 0,
            'order_new' => $orders_new->count(),
            'total_new' => $orders_new->sum('gross_revenue'),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    public function searchDateBranch($query, $input, $loc = 'created_at')
    {
        $query = $query->when(isset($input->branch_id) && $input->branch_id, function ($q) use ($input) {
            $q->where('branch_id', $input->branch_id);
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input, $loc) {
            $q->whereBetween($loc, [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        });
        return $query;
    }

    /**
     * Danh sách nhân viên nhóm (tại nhóm)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserCategory()
    {
        $data = User::select('id', 'full_name')->whereIn('role',
            [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->get();
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Search branch
     *
     * @param $query
     * @param $input
     * @return mixed
     */
    public function searchBranch($query, $input)
    {
        return $query->when(isset($input->branch_id) && $input->branch_id, function ($q) use ($input) {
            $q->where('branch_id', $input->branch_id);
        });
    }

}
