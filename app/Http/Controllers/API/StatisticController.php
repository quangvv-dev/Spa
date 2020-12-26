<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\CustomerPost;
use App\Models\Campaign;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Post;
use App\Models\Status;
use App\Models\Task;
use App\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Category;
use App\Helpers\Functions;
use App\Constants\UserConstant;
use App\Models\GroupComment;
use App\Models\WalletHistory;
use App\Models\Trademark;

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
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }

        $customers = Customer::select('id')->whereBetween('created_at', getTime($input['data_time']));
        $schedules = Schedule::getBooks($input);
        $payment = PaymentHistory::search($input);

        $orders = Order::returnRawData($input);
        $orders2 = clone $orders;
        $orders3 = clone $orders;
        $ordersYear = Order::whereYear('created_at', now('Asia/Ho_Chi_Minh')->format('Y'));

        $trademark = Trademark::select('id', 'name')->get()->map(function ($item) use ($input) {
            $services = Services::where('trademark', $item->id)->pluck('id')->toArray();
            $input['booking_id'] = $services;
            $item->price = OrderDetail::search($input)->sum('total_price');
            return $item;
        })->sortByDesc('price')->take(5);

        $wallet = WalletHistory::search($input);
        $arr = Services::getIdServiceType();
        $input['list_booking'] = $arr;
        $statusRevenues = Status::getRevenueSource($input);

        $category_service = Category::getTotalPrice($input, StatusCode::SERVICE, 5)->toArray();
        $category_product = OrderDetail::getTotalPriceBookingId($input, StatusCode::PRODUCT, 5)->toArray();
        $revenue_month = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'), \DB::raw('SUM(gross_revenue) AS revenue'))->whereBetween('payment_date', getTime($input['data_time']))
            ->whereNotNull('payment_date')->orderBy('payment_date', 'asc')->groupBy('payment_date')->get();


        $data = [
            'all_total' => $orders->sum('all_total'),
            'gross_revenue' => $orders->sum('gross_revenue'),
            'payment' => $payment->sum('price'),
            'orders' => $orders->count(),
            'customers' => $customers->count(),
            'category_service' => array_values($category_service),
            'category_product' => array_values($category_product),
            'revenue_month' => $revenue_month,
        ];
        $products = [
            'gross_revenue' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
        ];
        $services = [
            'gross_revenue' => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
        ];

        $revenue = self::getRevenueCustomer($input, $payment);
        $revenue_gender = [];
        $orders3 = $orders3->get();
        if (count($orders3)) {
            foreach ($orders3 as $item) {
                $revenue_gender[$item->customer->gender][] = !empty($item->gross_revenue) ? $item->gross_revenue : 0;
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

        $response = [
            'data' => $data,
            'products' => $products,
            'services' => $services,
            'statusRevenues' => array_values($statusRevenues),
            'revenue' => $revenue,
            'wallets' => $wallets,
            'trademark' => $trademark,
            'revenue_year' => $revenue_year,
            'schedules' => $schedules,
            'revenue_gender' => $revenue_gender,
        ];

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $response);

    }

    public function getRevenueCustomer($request, $payment)
    {
        $data_new = Customer::select('id')->whereBetween('created_at', getTime($request['data_time']));
        $data_old = Customer::select('id')->where('created_at', '<', getTime($request['data_time'])[0]);

        $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request['data_time']))->with('orderDetails');//doanh so
        $order_old = Order::whereBetween('created_at', getTime($request['data_time']))->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');
        return [
            'revenueNew' => $order_new->sum('gross_revenue'),
            'revenueOld' => $order_old->sum('gross_revenue'),
            'revenueRest' => ($payment->sum('price') - $order_new->sum('gross_revenue') - $order_old->sum('gross_revenue')) > 0 ? $payment->sum('price') - $order_new->sum('gross_revenue') - $order_old->sum('gross_revenue') : 0,
        ];
    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }

    /**
     * Doanh so, da thu trong ky
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBranch(Request $request)
    {
        $input = $request->all();
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        $payment = PaymentHistory::search($input);
        $payment2 = clone $payment;
        $orders = Order::returnRawData($input);
        $orders2 = clone $orders;
        $orders3 = clone $orders;

        $revenue_month = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'), \DB::raw('SUM(gross_revenue) AS revenue'))
            ->when(isset($input['data_time']) && $input['data_time'], function ($query) use ($input) {
                $query->whereBetween('payment_date', getTime($input['data_time']));
            })->when(!empty($request->end_date) && !empty($request->start_date), function ($query) use ($input) {
                $query->whereBetween('payment_date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            })->whereNotNull('payment_date')->orderBy('payment_date', 'asc')->groupBy('payment_date')->get();
        $total = [];
        $revenue = [];
        foreach ($revenue_month as $item) {
            $total[$item->payment_date] = (int)$item->total;
            $revenue[$item->payment_date] = (int)$item->revenue;
        }

        $customers = Customer::select('id')
            ->when(isset($input['data_time']) && $input['data_time'], function ($query) use ($input) {
                $query->whereBetween('created_at', getTime($input['data_time']));
            })->when(!empty($request->end_date) && !empty($request->start_date), function ($query) use ($input) {
                $query->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            });

        $revenueAll = self::getRevenueCustomer($input, $payment);
        $revenue_gender = [];
        $orders3 = $orders3->get();
        if (count($orders3)) {
            foreach ($orders3 as $item) {
                $revenue_gender[$item->customer->gender][] = !empty($item->gross_revenue) ? $item->gross_revenue : 0;
            }
        }

        $ordersYear = Order::whereYear('created_at', now('Asia/Ho_Chi_Minh')->format('Y'));
        $revenue_year = [];
        for ($i = 1; $i <= 12; $i++) {
            $newOrder = clone $ordersYear;
            $newOrder = $newOrder->whereMonth('created_at', $i)->sum('gross_revenue');
            $revenue_year[$i] = $newOrder;
        }

        $wallet = WalletHistory::search($input);
        $wallets = [
            'orders' => $wallet->count(),
            'revenue' => $wallet->sum('order_price'),
            'used' => $payment->where('payment_type', 3)->sum('price'),
        ];

        $data = [
            'all_total'         => $orders->sum('all_total'),
            'gross_revenue'     => $orders->sum('gross_revenue'),
            'payment'           => $payment2->sum('price'),
            'orders'            => $orders->count(),
            'customers'         => $customers->count(),
            'wallets'           => $wallets,
            'revenue_month'     => $revenue,
            'total_month'       => $total,
            'total_year'        => $revenue_year,
            'revenue_gender'    => $revenue_gender,
            'revenueAll'        => $revenueAll,
            'revenueProducts'   => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
            'revenueServices'   => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
        ];

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * Thống kê sales
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sales(Request $request)
    {
        $input = $request->all();
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        $users = User::select('id', 'full_name', 'phone')->whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {
            if (isset($input['data_time']) && $input['data_time']) {
                $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', getTime($input['data_time']));
                $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('created_at', '<', getTime($request->data_time)[0]);
                $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($input['data_time']))->with('orderDetails');
                $order_old = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');
                $comment = GroupComment::select('id')->where('user_id', $item->id)->whereBetween('created_at', getTime($input['data_time']))->get()->count();// trao doi
            } else {
                $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])->with('orderDetails');
                $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('created_at', '<', Functions::yearMonthDay($input['start_date']));
                $order_old = Order::whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');
                $comment = GroupComment::select('id')->where('user_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])->get()->count();// trao doi
            }
            $input['telesales'] = $item->id;
            $detail = PaymentHistory::search($input);
            $item->comment = $comment;
            $item->customer_new = $data_new->get()->count();
            $item->order_new = $order_new->count();
            $item->payment_new = $order_new->sum('gross_revenue') + $order_old->sum('gross_revenue');//da thu trong ky
            $item->all_total = $order_new->sum('all_total');//doanh so
            $item->all_payment = $detail->sum('price');//da thu trong ky
            return $item;
        })->sortByDesc('gross_revenue');

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);
    }

    /**
     * Sale with branch
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleWithBranch(Request $request)
    {
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }

        $users = User::whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', getTime($request->data_time));
            $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('created_at', '<', getTime($request->data_time)[0]);
            $data = Customer::select('id')->where('telesales_id', $item->id);

            $order = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data->pluck('id')->toArray())->with('orderDetails');
            $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->with('orderDetails');//doanh so
            $order_old = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');

            $item->comment_new = GroupComment::select('id')->whereIn('customer_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count();// trao doi moi
            $item->comment_old = GroupComment::select('id')->whereIn('customer_id', $data_old->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count(); // trao doi cu

            $item->schedules_new = Schedule::select('id')->where('creator_id', $item->id)->whereIn('user_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count();//lich hen
            $item->schedules_old = Schedule::select('id')->where('creator_id', $item->id)->whereIn('user_id', $data_old->pluck('id')->toArray())->whereBetween('date', getTime($request->data_time))->get()->count();//lich hen

            $request->merge(['telesales' => $item->id]);
            $detail = PaymentHistory::search($request->all());

            $item->all_payment = $detail->sum('price');
            $item->customer_new = $data_new->get()->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->revenue_new = $order_new->sum('all_total');
            $item->revenue_old = $order->sum('all_total') - $order_new->sum('all_total');
            $item->payment_revenue = $order->sum('gross_revenue');
            $item->payment_new = $order_new->sum('gross_revenue');//da thu trong ky
            $item->payment_old = $order->sum('gross_revenue') - $order_new->sum('gross_revenue'); //da thu trong ky

            $item->revenue_total = $order->sum('all_total');
            return $item;
        })->sortByDesc('all_payment');

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);

    }

    /**
     * Thống kê chiến dịch
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function campaign(Request $request)
    {
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }
        $input = $request->all();
        $campaign = Campaign::search($input)->count();
        $post = Post::search($input)->count();
        $customer = CustomerPost::search($input);
        $customer2 = clone $customer;

        $response = [
            'campaign' => $campaign,
            'posts' => $post,
            'all_customer' => $customer->count(),
            'call' => $customer->where('status', StatusConstant::CALL)->count(),
            'receive' => $customer2->where('status', StatusConstant::RECEIVE)->count(),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $response);
    }

    /**
     * Thống kê chiến dịch từng chi nhánh
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function campaignWithBranch(Request $request)
    {
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }
        $input = $request->all();
        $campaign = Campaign::search($input)->get()->map(function ($item) use ($input) {
            $input['campaign_id'] = $item->id;
            $customer = CustomerPost::search($input);
            $customer2 = clone $customer;
            $item->all_customer = $customer->count();
            $item->call = $customer->where('status', StatusConstant::CALL)->count();
            $item->receive = $customer2->where('status', StatusConstant::RECEIVE)->count();
            return $item;
        });
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $campaign);
    }

    /**
     * Thống kê lịch hẹn và công việc sale
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function TaskScheduleSale(Request $request)
    {
        $input = $request->all();
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        $users = User::select('id', 'full_name', 'phone')->whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {
            if (isset($input['data_time']) && $input['data_time']) {
                $schedule = Schedule::where('person_action', $item->id)->whereBetween('date', getTime($input['data_time']));
                $schedule2 = clone $schedule;
                $schedule3 = clone $schedule;
                $task = Task::where('user_id', $item->id)->whereBetween('date_from', getTime($input['data_time']));
                $task1 = clone $task;
            } else {
                $schedule = Schedule::where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $schedule2 = clone $schedule;
                $schedule3 = clone $schedule;
                $task = Task::where('user_id', $item->id)->whereBetween('date_from', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $task1 = clone $task;
            }
            $item->all_schedules = $schedule->count();
            $item->schedules_buy = $schedule->where('status', ScheduleConstant::DEN_MUA)->count();
            $item->schedules_notbuy = $schedule2->where('status', ScheduleConstant::CHUA_MUA)->count();
            $item->schedules_cancel = $schedule3->where('status', ScheduleConstant::HUY)->count();
            $item->all_task = $task->count();
            $item->all_done = $task->where('task_status_id', StatusCode::DONE_TASK)->count();
            $item->all_failed = $task1->where('task_status_id', StatusCode::FAILED_TASK)->count();

            return $item;
        })->sortByDesc('all_schedules');

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);
    }
}
