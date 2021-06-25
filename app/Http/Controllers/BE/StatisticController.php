<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Status;
use App\Models\Trademark;
use App\Models\WalletHistory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
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
        $this->middleware('permission:statistics.index', ['only' => ['index']]);
        $this->middleware('permission:statistics.taskSchedules', ['only' => ['taskSchedules']]);

        $user = User::get()->pluck('full_name', 'id')->toArray();
        $branchs = Branch::search()->pluck('name', 'id');
        $this->customer = $customer;
        view()->share([
            'user' => $user,
            'branchs' => $branchs,
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
        if (count($input) < 1) {
            $input['branch_id'] = 1;
        }
        if (empty($request->data_time)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        $customers = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->whereBetween('created_at', getTime($input['data_time']));
        $schedules = Schedule::getBooks($input, 'id');
        $payment = PaymentHistory::search($input, 'payment_type,price');
        $payment2 = clone $payment;
        $payment3 = clone $payment;
        $orders = Order::returnRawData($input);
        $orders2 = clone $orders;
        $orders3 = clone $orders;
        $orders4 = clone $orders;
        $ordersYear = Order::when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->whereYear('created_at', Date::now('Asia/Ho_Chi_Minh')->format('Y'));

        $trademark = Trademark::select('id', 'name')->get()->map(function ($item) use ($input) {
            $services = Services::where('trademark', $item->id)->pluck('id')->toArray();
            $input['booking_id'] = $services;
            $item->price = OrderDetail::search($input)->sum('total_price');
            return $item;
        })->sortByDesc('price')->take(5);

        $wallet = WalletHistory::search($input, 'order_price,payment_type,price');
        $arr = Services::getIdServiceType();
        $input['list_booking'] = $arr;
//        $statusRevenues = Status::getRevenueSource($input);

//        $category_service = Category::getTotalPrice($input, StatusCode::SERVICE, 5);
        $category_product = OrderDetail::getTotalPriceBookingId($input, StatusCode::PRODUCT, 5);

        $revenue_month = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'), \DB::raw('SUM(gross_revenue) AS revenue'))
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })
            ->whereBetween('payment_date', getTime($input['data_time']))->whereNotNull('payment_date')->orderBy('payment_date', 'asc')
            ->groupBy('payment_date')->get();

        $groupComment = GroupComment::whereBetween('created_at', getTime($input['data_time']));
        $data = [
            'all_total' => $orders->sum('all_total'),
            'gross_revenue' => $orders->sum('gross_revenue'),
            'payment' => $payment->sum('price'),
            'orders' => $orders->count(),
            'customers' => $customers->count(),
//            'category_service' => $category_service,
            'category_product' => $category_product,
            'revenue_month' => $revenue_month,
            'groupComment' => $groupComment->count(),
        ];
        $products = [
            'gross_revenue' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
            'all_total' => $orders->where('role_type', StatusCode::PRODUCT)->sum('all_total'),
            'orders' => $orders->where('role_type', StatusCode::PRODUCT)->count(),
        ];
        $services = [
            'gross_revenue' => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
            'all_total' => $orders2->where('role_type', StatusCode::SERVICE)->sum('all_total'),
            'orders' => $orders2->where('role_type', StatusCode::SERVICE)->count(),
        ];

        $revenue = self::getRevenueCustomer($input, $payment);

        $revenue_gender = [];
        $orders3 = $orders3->get();
        if (count($orders3)) {
            foreach ($orders3 as $item) {
                if (isset($item->customer->gender) && $item->customer->gender) {
                    $revenue_gender[$item->customer->gender][] = !empty($item->gross_revenue) ? $item->gross_revenue : 0;
                }
            }
        }
        $revenue_genitive = [];
        $orders4 = $orders4->get();
        if (count($orders4)) {
            foreach ($orders4 as $item) {
                if (isset($item->customer->genitive)) {
                    $revenue_genitive[@$item->customer->genitive->name][] = !empty($item->gross_revenue) ? $item->gross_revenue : 0;
                }
            }
        }
        $revenue_year = [];
        for ($i = 1; $i <= 12; $i++) {
            $newOrder = clone $ordersYear;
            $newOrder = $newOrder->whereMonth('created_at', $i)->sum('gross_revenue');
            $revenue_year[$i] = $newOrder;
        }
        $wallets = [
            'orders' => $wallet->count(),
            'revenue' => $wallet->sum('order_price'),
            'used' => $payment->where('payment_type', 3)->sum('price'),
        ];
        $list_payment = [
            'money' => $payment2->where('payment_type', 1)->sum('price'),
            'card' => $payment3->where('payment_type', 2)->sum('price'),
        ];
        if ($request->ajax()) {
            return Response::json(view('statistics.ajax', compact('data', 'services', 'products', 'list_payment', 'statusRevenues', 'schedules', 'wallets', 'trademark', 'revenue_gender', 'revenue_year', 'revenue', 'revenue_genitive'))->render());
        }
        return view('statistics.index', compact('data', 'services', 'products', 'statusRevenues', 'list_payment', 'schedules', 'wallets', 'trademark', 'revenue_gender', 'revenue_year', 'revenue', 'revenue_genitive'));
    }

    /**
     * Chi tiết thống kê
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }

    /**
     *
     *
     * @param $request
     * @param $payment
     * @return array
     */
    public function getRevenueCustomer($request, $payment)
    {
        $data_new = Customer::select('id')->when(isset($request['branch_id']) && isset($request['branch_id']), function ($q) use ($request) {
            $q->where('branch_id', $request['branch_id']);
        })->whereBetween('created_at', getTime($request['data_time']));
        $data_old = Customer::select('id')->when(isset($request['branch_id']) && isset($request['branch_id']), function ($q) use ($request) {
            $q->where('branch_id', $request['branch_id']);
        })->where('created_at', '<', getTime($request['data_time'])[0]);

        $order_new = Order::when(isset($request['branch_id']) && isset($request['branch_id']), function ($q) use ($request) {
            $q->where('branch_id', $request['branch_id']);
        })->whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request['data_time']))->with('orderDetails');//doanh so
        $order_old = Order::when(isset($request['branch_id']) && isset($request['branch_id']), function ($q) use ($request) {
            $q->where('branch_id', $request['branch_id']);
        })->whereBetween('created_at', getTime($request['data_time']))->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');
        return [
            'revenueNew' => $order_new->sum('gross_revenue'),
            'revenueOld' => $order_old->sum('gross_revenue'),
            'revenueRest' => ($payment->sum('price') - $order_new->sum('gross_revenue') - $order_old->sum('gross_revenue')) > 0 ? $payment->sum('price') - $order_new->sum('gross_revenue') - $order_old->sum('gross_revenue') : 0,
        ];
    }

    /**
     * Thống kê lịch hẹn
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
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
