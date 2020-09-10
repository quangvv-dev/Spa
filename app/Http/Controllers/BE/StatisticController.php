<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\Services;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\Task;
use App\Constants\UserConstant;
use App\Helpers\Functions;

class StatisticController extends Controller
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
     * Thống kê hệ thống
     *
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $input = $request->all();
        if (empty($request->data_time)) {
            $input['data_time'] = 'THIS_MONTH';
        }

        $customers = Customer::select('id')->whereBetween('created_at', getTime($input['data_time']));
        $payment = PaymentHistory::search($input);

        $orders = Order::returnRawData($input);
        $orders2 = Order::returnRawData($input);

        $arr = Services::getIdServiceType();
        $input['list_booking'] = $arr;
        $statusRevenues = Status::getRevenueSource($input);

        $category_service = Category::getTotalPrice($input, StatusCode::SERVICE, 5);
        $category_product = OrderDetail::getTotalPriceBookingId($input, StatusCode::PRODUCT, 5);

        $revenue_month = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'), \DB::raw('SUM(gross_revenue) AS revenue'))->whereBetween('payment_date', getTime($input['data_time']))
            ->whereNotNull('payment_date')->orderBy('payment_date', 'asc')->groupBy('payment_date')->get();


        $data = [
            'all_total' => $orders->sum('all_total'),
            'gross_revenue' => $orders->sum('gross_revenue'),
            'payment' => $payment->sum('price'),
            'orders' => $orders->count(),
            'customers' => $customers->count(),
            'category_service' => $category_service,
            'category_product' => $category_product,
            'revenue_month' => $revenue_month,
        ];
        $products = [
            'orders' => $orders->where('role_type', StatusCode::PRODUCT)->count(),
            'all_total' => $orders->where('role_type', StatusCode::PRODUCT)->sum('all_total'),
            'gross_revenue' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
            'the_rest' => $orders->where('role_type', StatusCode::PRODUCT)->sum('the_rest'),
        ];
        $services = [
            'orders' => $orders2->where('role_type', StatusCode::SERVICE)->get()->count(),
            'all_total' => $orders2->where('role_type', StatusCode::SERVICE)->sum('all_total'),
            'gross_revenue' => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
            'the_rest' => $orders2->where('role_type', StatusCode::SERVICE)->sum('the_rest'),
        ];


        if ($request->ajax()) {
            return Response::json(view('statistics.ajax', compact('data', 'services', 'products', 'statusRevenues'))->render());
        }
        return view('statistics.index', compact('data', 'services', 'products', 'statusRevenues'));
    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }

    public function taskSchedules(Request $request)
    {
        $input = $request->all();
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        $users = User::select('id', 'full_name', 'phone')->whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {
            if (isset($input['data_time']) && $input['data_time']) {
                $schedule = Schedule::where('person_action', $item->id)->whereBetween('date', getTime($input['data_time']));
                $schedule2 = Schedule::where('person_action', $item->id)->whereBetween('date', getTime($input['data_time']));
                $schedule3 = Schedule::where('person_action', $item->id)->whereBetween('date', getTime($input['data_time']));
                $task = Task::where('user_id', $item->id)->whereBetween('date_from', getTime($input['data_time']));
                $task1 = Task::where('user_id', $item->id)->whereBetween('date_from', getTime($input['data_time']));
            } else {
                $schedule = Schedule::where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $schedule2 = Schedule::where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $schedule3 = Schedule::where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $task = Task::where('user_id', $item->id)->whereBetween('date_from', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $task1 = Task::where('user_id', $item->id)->whereBetween('date_from', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            }
            $item->all_schedules = $schedule->count();
            $item->schedules_buy = $schedule->where('status', 3)->count();
            $item->schedules_notbuy = $schedule2->where('status', 4)->count();
            $item->schedules_cancel = $schedule3->where('status', 5)->count();
            $item->all_task = $task->count();
            $item->all_done = $task->where('task_status_id', StatusCode::DONE_TASK)->count();
            $item->all_failed = $task1->where('task_status_id', StatusCode::FAILED_TASK)->count();

            return $item;
        })->sortByDesc('all_schedules');

        if ($request->ajax()) {
            return Response::json(view('statistics.ajax_taskSchedule', compact('users'))->render());
        }

        return view('statistics.task_schedule', compact('users'));

    }
}
