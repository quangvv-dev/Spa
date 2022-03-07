<?php

namespace App\Http\Controllers\BE;

use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\Status;
use App\Models\ThuChi;
use App\Models\Trademark;
use App\Models\WalletHistory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use App\Models\Services;
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
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();

        if (count($input) == 2) {
            $input['branch_id'] = 1;
        }
        $customers = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);

        $schedule = Schedule::getBooks2($input, 'id');

        $schedules = [
            'all_schedules' => $schedule->count(),
            'become' => $schedule->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
                ->whereHas('customer', function ($qr) {
                    $qr->where('old_customer', 0);
                })->count(),
        ];
        $payment = PaymentHistory::search($input, 'price');
        $payment2 = clone $payment;
        $payment3 = clone $payment;
        $orders = Order::returnRawData($input);
        $orders2 = clone $orders;
        $orders3 = clone $orders;
        $orders_combo = clone $orders;
        $ordersYear = Order::when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->whereYear('created_at', Date::now('Asia/Ho_Chi_Minh')->format('Y'));

        $trademark = Trademark::select('id', 'name')->get()->map(function ($item) use ($input) {
            $services = Services::select('id')->where('trademark', $item->id)->pluck('id')->toArray();
            $input['booking_id'] = $services;
            $item->price = OrderDetail::search($input)->select('total_price')->sum('total_price');
            return $item;
        })->sortByDesc('price')->take(5);

        $wallet = WalletHistory::search($input, 'order_price,payment_type,price');
        $payment_wallet = PaymentWallet::search($input, 'price');
        $arr = Services::getIdServiceType();
        $input['list_booking'] = $arr;
        //Status Revuenue
        $sources = Status::select('id', 'name')->where('type', StatusCode::SOURCE_CUSTOMER)->get();
        $order_detail = OrderDetail::search($input, 'total_price');
        $statusRevenues = [];
        foreach ($sources as $source) {
            $price = clone $order_detail;
            $price = $price->whereHas('user', function ($qr) use ($source) {
                $qr->where('source_id', $source->id);
            });
            if ((int)$price->sum('total_price') > 0) {
                $statusRevenues[] = [
                    'revenue' => (int)$price->sum('total_price'),
                    'name' => $source->name,
                ];
            }
        }
        //END
//        $category_service = Category::getTotalPrice($input, StatusCode::SERVICE, 5);

        $category_product = OrderDetail::getTotalPriceBookingId($input, StatusCode::PRODUCT, 5);

        $revenue_month = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'), \DB::raw('SUM(gross_revenue) AS revenue'))
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })
            ->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])
            ->whereNotNull('payment_date')->orderBy('payment_date', 'asc')->groupBy('payment_date')->get();

        $data = [
            'all_total' => $orders->sum('all_total'),
            'gross_revenue' => $orders->sum('gross_revenue'),
            'payment' => $payment->sum('price'),
            'orders' => $orders->count(),
            'customers' => $customers->count(),
//            'category_service' => $category_service,
            'category_product' => $category_product,
            'revenue_month' => $revenue_month,
        ];
        $products = [
            'gross_revenue' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
            'all_total' => $orders->where('role_type', StatusCode::PRODUCT)->sum('all_total'),
            'orders' => $orders->where('role_type', StatusCode::PRODUCT)->count(),
        ];
        $services = [
            'gross_revenue' => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
            'all_total' => $orders2->where('role_type', StatusCode::SERVICE)->sum('all_total'),
            'combo_total' => $orders_combo->where('role_type', StatusCode::COMBOS)->sum('all_total'),
            'orders' => $orders2->where('role_type', StatusCode::SERVICE)->count(),
        ];

        $revenue = self::getRevenueCustomer($input, $payment);

        $revenue_gender = [];
        $orders3 = $orders3->get();
        if (count($orders3)) {
            foreach ($orders3 as $item) {
                if (isset($item->customer)) {
                    $revenue_gender[$item->customer->gender][] = !empty($item->gross_revenue) ? $item->gross_revenue : 0;
                }
            }
        }

        $revenue_year = [];
        for ($i = 1; $i <= 12; $i++) {
            $newOrder = clone $ordersYear;
            $newOrder = $newOrder->whereMonth('created_at', $i)->sum('gross_revenue');
            $revenue_year[$i] = $newOrder;
        }
        $all_payment = $payment->sum('price');
        $list_payment = [
            'money' => $payment2->where('payment_type', 1)->sum('price'),
            'card' => $payment3->where('payment_type', 2)->sum('price'),
            'CK' => $payment->where('payment_type', 4)->sum('price'),
        ];
        $wallets = [
            'payment' => $payment_wallet->sum('price'),
            'orders' => $wallet->count(),
            'revenue' => $wallet->sum('order_price'),
            'used' => $all_payment - $list_payment['money'] - $list_payment['card'] - $list_payment['CK'],
        ];

        if ($request->ajax()) {
            return view('statistics.ajax', compact('data', 'services', 'products', 'statusRevenues', 'list_payment', 'schedules', 'wallets', 'trademark', 'revenue_gender', 'revenue_year', 'revenue'));
        }
        return view('statistics.index', compact('data', 'services', 'products', 'statusRevenues', 'list_payment', 'schedules', 'wallets', 'trademark', 'revenue_gender', 'revenue_year', 'revenue'));
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
        })->whereBetween('created_at', [Functions::yearMonthDay($request['start_date']) . " 00:00:00", Functions::yearMonthDay($request['end_date']) . " 23:59:59"]);
        $data_old = Customer::select('id')->when(isset($request['branch_id']) && isset($request['branch_id']), function ($q) use ($request) {
            $q->where('branch_id', $request['branch_id']);
        })->where('old_customer', 1);

        $order_new = Order::select('gross_revenue')->when(isset($request['branch_id']) && isset($request['branch_id']), function ($q) use ($request) {
            $q->where('branch_id', $request['branch_id']);
        })->whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', [Functions::yearMonthDay($request['start_date']) . " 00:00:00", Functions::yearMonthDay($request['end_date']) . " 23:59:59"])->with('orderDetails');//doanh so
        $order_old = Order::select('gross_revenue')->when(isset($request['branch_id']) && isset($request['branch_id']), function ($q) use ($request) {
            $q->where('branch_id', $request['branch_id']);
        })->whereBetween('created_at', [Functions::yearMonthDay($request['start_date']) . " 00:00:00", Functions::yearMonthDay($request['end_date']) . " 23:59:59"])->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');
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
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();

        $users = User::select('id', 'full_name', 'phone')->whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {
            if (isset($input['data_time']) && $input['data_time']) {
                $schedule = Schedule::select('id')->where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $schedule2 = Schedule::select('id')->where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $schedule3 = Schedule::select('id')->where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $task = Task::where('user_id', $item->id)->whereBetween('date_from', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $task1 = Task::where('user_id', $item->id)->whereBetween('date_from', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            } else {
                $schedule = Schedule::select('id')->where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $schedule2 = Schedule::select('id')->where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $schedule3 = Schedule::select('id')->where('person_action', $item->id)->whereBetween('date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $task = Task::select('id')->where('user_id', $item->id)->whereBetween('date_from', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $task1 = Task::select('id')->where('user_id', $item->id)->whereBetween('date_from', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
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
            return view('statistics.ajax_taskSchedule', compact('users'));
        }

        return view('statistics.task_schedule', compact('users'));

    }

    /**
     * BĐ duyệt chi
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chartPay(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $payment = PaymentHistory::search($input, 'price');
        $payment2 = clone $payment;
        $payment3 = clone $payment;
        $payment_wallet = PaymentWallet::search($input, 'price');
        $payment_wallet2 = clone $payment_wallet;
        $payment_wallet3 = clone $payment_wallet;
        $all_payment = $payment->sum('price');

        $list_payment = [
            'money' => $payment2->where('payment_type', 1)->sum('price') + $payment_wallet->where('payment_type', 1)->sum('price'),
            'card' => $payment3->where('payment_type', 2)->sum('price') + $payment_wallet2->where('payment_type', 2)->sum('price'),
            'CK' => $payment->where('payment_type', 4)->sum('price') + $payment_wallet3->where('payment_type', 4)->sum('price'),
        ];
        $payCurrent = ThuChi::when(isset($input['branch_id']) && $input['branch_id'], function ($query) use ($input) {
            $query->where('branch_id', $input['branch_id']);
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($query) use ($input) {
            $query->whereBetween('created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        });
        $payTwice = clone $payCurrent;
        $pay = $payCurrent->where('status', UserConstant::ACTIVE);
        $pay2 = clone $pay;
        $pay3 = clone $pay;
        $payAll = clone $pay;
        $payBranch = clone $pay;
        $payAll = $payAll->select('so_tien', 'danh_muc_thu_chi_id', \DB::raw('SUM(so_tien) AS sum_price'))
            ->with('danhMucThuChi')->groupBy('danh_muc_thu_chi_id')->get();
        $payStatus = $payTwice->select('so_tien', 'status', \DB::raw('SUM(so_tien) AS sum_price'))
            ->groupBy('status')->get();
        $payBranch = $payBranch->select('so_tien', 'branch_id', \DB::raw('SUM(so_tien) AS sum_price'))->with('branch')
            ->groupBy('branch_id')->orderByDesc('sum_price')->get();
        $list_pay = [
            'money' => $pay2->where('type', 1)->sum('so_tien'),
            'card' => $pay3->where('type', 2)->sum('so_tien'),
            'CK' => $pay->where('type', 4)->sum('so_tien'),
        ];

        $data = [
            'payment' => $all_payment,
            'wallet_payment' => $payment_wallet->sum('price'),
        ];

        if ($request->ajax()) {
            return view('thu_chi.statistics.ajax', compact('list_payment', 'data', 'list_pay', 'payAll','payStatus','payBranch'));
        }

        return view('thu_chi.statistics.index', compact('list_payment', 'data', 'list_pay', 'payAll','payStatus','payBranch'));
    }
}
