<?php

namespace App\Http\Controllers\API;

use App\Constants\OrderConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Http\Resources\CategoryRevenueResource;
use App\Http\Resources\SchedulesResource;
use App\Http\Resources\TasksResource;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Services;
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
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $users = User::select('id', 'full_name')
            ->whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER, UserConstant::CSKH, UserConstant::TP_CSKH])
            ->get()->map(function ($item) use ($input) {
                $schedule = Schedule::select('status')->where('person_action', $item->id)->whereBetween('date', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ])->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                });
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
        $users = User::select('id', 'full_name')->whereIn('role', [UserConstant::TELESALES, UserConstant::CSKH, UserConstant::TP_CSKH])
            ->get()->map(function ($item) use ($input) {
                $task = Task::where('user_id', $item->id)->whereBetween('date_from', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ])->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                });
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
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $category = Category::select('id', 'name', 'type')->where('type', $request->type)->get()->map(function ($item) use ($input) {
            $services = Services::select('id')->where('category_id', $item->id)->pluck('id')->toArray();
            $order_id = OrderDetail::select('order_id')->whereIn('booking_id', $services)
                ->when(!empty($input['start_date']) && !empty($input['end_date']),
                    function ($q) use ($input) {
                        $q->whereBetween('created_at', [
                            Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                            Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                        ]);
                    })
                ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                })->groupBy('order_id')->pluck('order_id')->toArray();
            $order = Order::select('gross_revenue', 'total', 'member_id')->whereIn('id', $order_id)
                ->when(!empty($input['start_date']) && !empty($input['end_date']),
                    function ($q) use ($input) {
                        $q->whereBetween('created_at', [
                            Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                            Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                        ]);
                    })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                });

            $item->orders = $order->count();
            $item->revuenue = $order->sum('gross_revenue');//da thu trong ky thu thêm
            $item->total = $order->sum('all_total');//da thu trong ky thu thêm
            return $item;
        })->sortByDesc('revuenue');
        $data['sumOrders'] = $category->sum('orders');
        $data['sumRevenue'] = $category->sum('revuenue');
        $data['sumTotal'] = $category->sum('total');
        $data['records'] = CategoryRevenueResource::collection($category);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function groupDetail(Request $request, $id)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }

        $input = $request->all();
        $category = Category::find($id);
        $group = CustomerGroup::select('customer_id')->where('category_id', $category->id);
        $arr_customer = self::searchDateBranch($group, $input);


        $services = Services::select('id')->where('category_id', $category->id)->pluck('id')->toArray();
        $order_id = OrderDetail::select('order_id')->whereIn('booking_id', $services)
            ->when(!empty($input['start_date']) && !empty($input['end_date']),
                function ($q) use ($input) {
                    $q->whereBetween('created_at', [
                        Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                        Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                    ]);
                })
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })->groupBy('order_id')->pluck('order_id')->toArray();

//        $customer = Customer::select('id')->whereIn('id', $arr_customer);
//        $data_new = self::searchDateBranch($customer, $input);
//        $ordersAll = Order::returnRawData($input);

        $ordersAll = Order::select('id', 'member_id', 'all_total', 'gross_revenue')->whereIn('id', $order_id);
        $orders_new = $ordersAll->where('is_upsale', OrderConstant::NON_UPSALE)->with('orderDetails');

        $schedules = Schedule::select('id')->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            });
        $schedules_new = $schedules->whereIn('user_id', $arr_customer->pluck('customer_id')->toArray());

        $data = [
            'phone' => $arr_customer->count(),
            'schedules_new' => $schedules_new->count(),
            'schedules_den' => $schedules_new->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count(),
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
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        })
        ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input, $loc) {
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
