<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\Status;
use App\Models\ThuChi;
use App\Models\Trademark;
use App\Models\WalletHistory;
use App\Services\CustomerService;
use App\Services\OrderDetailService;
use App\Services\OrderService;
use App\Services\StatisticService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
    public function __construct(Customer $customer, OrderDetailService $orderDetailService, OrderService $orderService
    ,CustomerService $customerService)
    {
        $this->middleware('permission:statistics.index', ['only' => ['index']]);
        $this->middleware('permission:statistics.taskSchedules', ['only' => ['taskSchedules']]);

        $user = User::select('id', 'full_name')->pluck('full_name', 'id')->toArray();
        $branchs = Branch::search()->pluck('name', 'id');
        $this->customer = $customer;
        $this->customerService = $customerService;
        $this->orderDetail = $orderDetailService;
        $this->orderService = $orderService;
        $location = Location::select('id', 'name')->pluck('name', 'id')->toArray();
        view()->share([
            'user' => $user,
            'branchs' => $branchs,
            'location' => $location,
        ]);
    }

    /**
     * Thống kê hệ thống
     *
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::select('id')->where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = count($group_branch) ? $group_branch : [0];
        }
        $user = Auth::user();

        if (count($input) == 2) {
            $input['branch_id'] = $user->branch_id ?? 1;
        }
        if (!in_array($user->department_id, [DepartmentConstant::KE_TOAN, DepartmentConstant::MARKETING, DepartmentConstant::TELESALES]) && ($user->department_id != DepartmentConstant::BAN_GIAM_DOC || ($user->department_id == DepartmentConstant::BAN_GIAM_DOC && $user->branch_id != null))) {
            $input['branch_id'] = $user->branch_id;
        }
        $customers = Customer::select('id')
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        })->whereBetween('created_at', [
            Functions::yearMonthDay($input['start_date']) . " 00:00:00",
            Functions::yearMonthDay($input['end_date']) . " 23:59:59",
        ]);

        $schedule = Schedule::getBooks2($input, 'id');
        $schedules = [
            'all_schedules' => $schedule->count(),
            'become' => $schedule->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
                ->whereHas('customer', function ($qr) {
                    $qr->where('old_customer', 0);
                })->count(),
        ];

        $payment_All = PaymentHistory::select('price')->when(isset($input['branch_id']) && $input['branch_id'],
            function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        });

        $payment = clone $payment_All;
        $payment = $payment->whereBetween('payment_date', [
            Functions::yearMonthDay($input['start_date']) . " 00:00:00",
            Functions::yearMonthDay($input['end_date']) . " 23:59:59",
        ])->with('order')->has('order');
        $payment2 = clone $payment;
        $payment3 = clone $payment;
        $paymentMonth = clone $payment;
        $payment_isdebt = clone $payment;
        $payment_years = clone $payment_All;
        $orders = Order::returnRawData($input);
        $order_single = clone $orders;
        $order_multiple = clone $orders;
        $orders2 = clone $orders;
        $orders_combo = clone $orders;
        $ordersYear = $payment_years->whereYear('payment_date', Date::now('Asia/Ho_Chi_Minh')->format('Y'));

//        $trademark = $this->orderDetail->revenueWithTrademark($input)->take(5);

        $wallet = WalletHistory::search($input, 'order_price,payment_type,price');
        $payment_wallet = PaymentWallet::search($input, 'price');
        //Status Revuenue
        $statusRevenues = $this->orderDetail->revenueWithSource($input);
        //END
        $category_product = $this->orderDetail->revenueWithService($input)->take(5);
        $statusCustomer = $this->customerService->countWithStatus($input);

        $revenue_month = $paymentMonth->select('payment_date', 'branch_id', \DB::raw('SUM(price) AS payment_revenue'))->groupBy('payment_date')
            ->get()->map(function ($item) use ($request) {
                $item->wallet_month = WalletHistory::select('order_price')
                    ->whereBetween('created_at', [$item->payment_date . " 00:00:00", $item->payment_date . " 23:59:59"])
                    ->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                        $q->where('branch_id', $request->branch_id);
                    })->sum('order_price');
                $item->payment_wallet_month = PaymentWallet::select('price')
                    ->whereBetween('payment_date', [$item->payment_date . " 00:00:00", $item->payment_date . " 23:59:59"])
                    ->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                        $q->where('branch_id', $request->branch_id);
                    })->sum('price');
                $item->order_month = Order::select('all_total')
                    ->whereBetween('created_at', [$item->payment_date . " 00:00:00", $item->payment_date . " 23:59:59"])
                    ->when(isset($request->branch_id) && $request->branch_id, function ($q) use ($request) {
                        $q->where('branch_id', $request->branch_id);
                    })->sum('all_total');
                return $item;
            });

        $data = [
            'all_total' => $orders->sum('all_total'),
            'gross_revenue' => $orders->sum('gross_revenue'),
            'payment' => $payment->sum('price'),
            'is_debt' => $payment_isdebt->where('is_debt', StatusCode::ON)->sum('price'),
//            'is_debt' => $payment->sum('price') - $orders->sum('gross_revenue'),
            'orders' => $orders->count(),
            'customers' => $customers->count(),
            //            'category_service' => $category_service,
            'category_product' => $category_product,
            'statusCustomer' => $statusCustomer,
            'revenue_month' => $revenue_month,
            'order_single' => $order_single->whereIn('role_type', [StatusCode::SERVICE, StatusCode::COMBOS])->where('all_total', '<', 1000000)->count(),
            'order_multiple' => $order_multiple->whereIn('role_type', [StatusCode::SERVICE, StatusCode::COMBOS])->where('all_total', '>=', 1000000)->count(),
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
            'combo_gross' => $orders_combo->where('role_type', StatusCode::COMBOS)->sum('gross_revenue'),
            'orders' => $orders2->where('role_type', StatusCode::SERVICE)->count(),
        ];

        $revenue = self::getRevenueCustomer($input, $payment);

        $revenue_gender = $this->orderService->revenueGenderWithOrders($input);
        $revenue_locale = $this->orderService->revenueLocaleWithOrders($input);

        $revenue_year = $ordersYear->select(\DB::raw('SUM(price) as all_total'), \DB::raw('MONTH(payment_date) month'))->groupBy('month')->get();
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
            return view('statistics.ajax',
                compact('data', 'services', 'products', 'statusRevenues', 'list_payment', 'schedules', 'wallets',
                    'revenue_gender', 'revenue_year', 'revenue','revenue_locale'));
        }
        return view('statistics.index',
            compact('data', 'services', 'products', 'statusRevenues', 'list_payment', 'schedules', 'wallets',
                'revenue_gender', 'revenue_year', 'revenue','revenue_locale'));
    }

    /**
     * Chi tiết thống kê
     *
     * @param $id
     *
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
     *
     * @return array
     */
    public function getRevenueCustomer($request, $payment)
    {
        $paymentNew = clone $payment;
        $paymentOld = clone $payment;
        $paymentNew = $paymentNew->whereHas('order', function ($qr) {
            $qr->where('is_upsale', OrderConstant::NON_UPSALE);
        });
        $paymentOld = $paymentOld->whereHas('order', function ($qr) {
            $qr->where('is_upsale', OrderConstant::IS_UPSALE);
        });
        return [
            'revenueNew' => $paymentNew->sum('price'),
            'revenueOld' => $paymentOld->sum('price'),
        ];
    }

    /**
     * Thống kê lịch hẹn
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function taskSchedules(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }

        $users = User::select('id', 'full_name', 'phone')->whereIn('role',
            [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {

            $schedule = Schedule::select('id')->where('person_action', $item->id)->whereBetween('date', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
                ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                });
            $schedule2 = clone $schedule;
            $schedule3 = clone $schedule;
            $task = Task::select('id')->where('user_id', $item->id)->whereBetween('date_from', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ])
                ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                    $q->whereIn('branch_id', $input['group_branch']);
                });
            $task1 = clone $task;

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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chartPay(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $user = Auth::user();
        if (!in_array($user->department_id, [DepartmentConstant::KE_TOAN, DepartmentConstant::MARKETING, DepartmentConstant::TELESALES]) && ($user->department_id != DepartmentConstant::BAN_GIAM_DOC || ($user->department_id == DepartmentConstant::BAN_GIAM_DOC && $user->branch_id != null))) {
            $input['branch_id'] = $user->branch_id;
        }
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $payment = PaymentHistory::search($input, 'price');
        $payment2 = clone $payment;
        $payment3 = clone $payment;
        $payment_wallet = PaymentWallet::search($input, 'price');
        $payment_wallet2 = clone $payment_wallet;
        $payment_wallet3 = clone $payment_wallet;
        $all_payment = $payment->sum('price');

        $list_payment = [
            'money' => $payment2->where('payment_type', 1)->sum('price') + $payment_wallet->where('payment_type',
                    1)->sum('price'),
            'card' => $payment3->where('payment_type', 2)->sum('price') + $payment_wallet2->where('payment_type',
                    2)->sum('price'),
            'CK' => $payment->where('payment_type', 4)->sum('price') + $payment_wallet3->where('payment_type',
                    4)->sum('price'),
        ];
        $payCurrent = ThuChi::when(isset($input['branch_id']) && $input['branch_id'], function ($query) use ($input) {
            $query->where('branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($query) use ($input) {
                $query->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            });
        $payTwice = clone $payCurrent;
        $pay = $payCurrent->where('status', UserConstant::ACTIVE);
        $pay2 = clone $pay;
//        $pay3 = clone $pay;
        $payAll = clone $pay;
        $payBranch = clone $pay;

        $payAll = $payAll->select('so_tien', 'danh_muc_thu_chi_id', \DB::raw('SUM(so_tien) AS sum_price'))
            ->with('danhMucThuChi')->groupBy('danh_muc_thu_chi_id')->get();
        $payStatus = $payTwice->select('so_tien', 'status', \DB::raw('SUM(so_tien) AS sum_price'))
            ->groupBy('status')->get();
        $payBranch = $payBranch->select('so_tien', 'branch_id', \DB::raw('SUM(so_tien) AS sum_price'))->with('branch')
            ->groupBy('branch_id')->orderByDesc('sum_price')->get();
        $list_pay = [
            'money' => $pay2->where('type', 0)->sum('so_tien'),
            //            'card' => $pay3->where('type', 1)->sum('so_tien'),
            'CK' => $pay->where('type', 1)->sum('so_tien'),
        ];


        $data = [
            'payment' => $all_payment,
            'wallet_payment' => $payment_wallet->sum('price'),
        ];

        if ($request->ajax()) {
            return view('thu_chi.statistics.ajax',
                compact('list_payment', 'data', 'list_pay', 'payAll', 'payStatus', 'payBranch'));
        }

        return view('thu_chi.statistics.index',
            compact('list_payment', 'data', 'list_pay', 'payAll', 'payStatus', 'payBranch'));
    }
}
