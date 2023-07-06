<?php

namespace App\Http\Controllers\API;

use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Resources\ChartResource;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\GroupComment;
use App\Models\HistoryUpdateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\Schedule;
use App\Models\Services;
use App\Models\Status;
use App\Models\ThuChi;
use App\Models\WalletHistory;
use App\Services\CustomerService;
use App\Services\OrderDetailService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Constants\ResponseStatusCode;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Clone_;

class RevenueController extends BaseApiController
{

    /**
     * StatisticController constructor.
     *
     * @param Customer $customer
     */
    public function __construct(OrderService $orderService, CustomerService $customer,OrderDetailService $orderDetailService)
    {
        $this->orderService = $orderService;
        $this->customer = $customer;
        $this->orderDetail = $orderDetailService;
    }

    /**
     * Khách hàng mới doanh thu.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $customers = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'],
            function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })
            ->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            });

        $schedules = Schedule::getBooks2($input, 'id');

        $groupComment = GroupComment::select('id')->when(isset($input['branch_id']) && $input['branch_id'],
            function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        })
            ->whereBetween('created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        if (isset($input['old_start']) && isset($input['old_end'])) {
            $customers_old = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'],
                function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })
                ->whereBetween('created_at', [
                    Functions::yearMonthDay($input['old_start']) . " 00:00:00",
                    Functions::yearMonthDay($input['old_end']) . " 23:59:59",
                ]);
        }

        $data = [
            'customer_new' => $customers->count(),
            'schedules' => $schedules->count(),
            'groupComment' => $groupComment->count(),
            'percent' => !empty($customers->count()) && (isset($customers_old) && !empty($customers_old->count())) ? round(($customers->count() - $customers_old->count()) / $customers_old->count() * 100,
                2) : 0,
        ];
        $history = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
            ->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 0);
            })->count();
        $data['become'] = $history;

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Đơn hàng list block 1
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function orders(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->except('type_api');
        $input_old = [
            'branch_id' => $request->branch_id,
            'start_date' => $request->old_start,
            'end_date' => $request->old_end,
        ];
        $wallet = WalletHistory::search($input, 'order_price');
        $payment_wallet = PaymentWallet::search($input, 'price');

        $orders = Order::returnRawData($input);
        $orders2 = clone $orders;
        $orders_combo = clone $orders;
        $orders_old = [];
        $payment_old = [];
        if (isset($input_old['start_date']) && isset($input_old['end_date'])) {
            $orders_old = Order::returnRawData($input_old);
        }
        if ($request->type_api == 1) {
            $orders_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $orders_old->count() : 0;
            $data = [
                'orders' => $orders->count() + $wallet->count(),
                'percent' => !empty($orders->count()) && !empty($orders_old) ? round(($orders->count() - $orders_old) / $orders_old * 100,
                    2) : 0,
                'order_product' => $orders->where('role_type', StatusCode::PRODUCT)->count(),
                'order_services' => $orders2->where('role_type', StatusCode::SERVICE)->count(),
                'order_combo' => $orders_combo->where('role_type', StatusCode::COMBOS)->count(),
                'wallets' => $wallet->count(),
            ];
        } elseif ($request->type_api == 2) {
            $orders_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $orders_old->sum('all_total') : 0;

            $data = [
                'total' => $orders->sum('all_total') + $wallet->sum('order_price'),
                'percent' => !empty($orders->sum('all_total')) && !empty($orders_old) ? round(($orders->count() - $orders_old) / $orders_old * 100,
                    2) : 0,
                'total_product' => $orders->where('role_type', StatusCode::PRODUCT)->sum('all_total'),
                'total_services' => $orders2->where('role_type', StatusCode::SERVICE)->sum('all_total'),
                'total_combo' => $orders_combo->where('role_type', StatusCode::COMBOS)->sum('all_total'),
                'wallet' => $wallet->sum('order_price'),
            ];
        } elseif ($request->type_api == 3) {
            $payment = PaymentHistory::search($input, 'price');
            $is_debt = clone $payment;
            if (isset($input_old['start_date']) && isset($input_old['end_date'])) {
                $payment_old = PaymentHistory::search($input_old, 'price');
            }
            $payment_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $payment_old->sum('price') : 0;

            $data = [
                'percent' => !empty($payment->sum('price')) && !empty($payment_old) ? round(($payment->sum('price') - $payment_old) / $payment_old * 100,
                    2) : 0,
                //                'wallet' => $wallet->sum('order_price'),
                'wallet' => $payment_wallet->sum('price'),
                'thu_no' => $is_debt->where('is_debt', StatusCode::ON)->sum('price'),
                'con_no' => $orders->sum('all_total') - $orders->sum('gross_revenue'),
            ];
            $total_payment = $payment->sum('price');
            $wallet_used = $payment->where('payment_type', 3)->sum('price');
            $data['gross_revenue'] = $total_payment - $wallet_used - $data['thu_no'];
            $data['payment'] = $total_payment + $payment_wallet->sum('price') - $wallet_used;

        } elseif ($request->type_api == 4) {
            if (isset($input_old['start_date']) && isset($input_old['end_date'])) {
                $payment_old = PaymentHistory::search($input_old, 'price');
            }
            $payment_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $payment_old->sum('price') : 0;

            $payment = PaymentHistory::search($input, 'price');
            $payment2 = clone $payment;
            $payment3 = clone $payment;
            $all_payment = $payment->sum('price');

            $data = [
                'payment' => (int)$payment->sum('price') + $payment_wallet->sum('price'),
                'percent' => !empty($all_payment) && !empty($payment_old) ? round(($all_payment - $payment_old) / $payment_old * 100,
                    2) : 0,
                'cash' => (int)$payment->whereIn('payment_type', [0, 1])->sum('price'),
                'card' => (int)$payment2->where('payment_type', 2)->sum('price'),
                'wallet_used' => $payment3->where('payment_type', 3)->sum('price'),
                'wallet' => $payment_wallet->sum('price'),
            ];
            $data['CK'] = $all_payment - $data['cash'] - $data['card'] - $data['wallet_used'];
        }

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Tab Schedules
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabSchedules(Request $request)
    {
        $input = $request->except('old_start', 'old_end');
        $input_old = [
            'branch_id' => $request->branch_id,
            'start_date' => $request->old_start,
            'end_date' => $request->old_end,
        ];
        $schedule_old = 0;
        $schedule = Schedule::search($input)->select('status');
        if (isset($request->old_start) && isset($request->old_end)) {
            $schedule_old = Schedule::search($input_old)->select('status')->count();
        }
        $schedule2 = clone $schedule;
        $schedule3 = clone $schedule;

        $data = [
            'all_schedules' => $schedule->count(),
            'percent' => !empty($schedule->count()) && !empty($schedule_old) ? round(($schedule->count()) - $schedule_old) / $schedule_old * 100 : 0,
            'schedules_buy' => $schedule->where('status', 3)->count(),
            'schedules_notbuy' => $schedule2->where('status', 4)->count(),
            'schedules_cancel' => $schedule3->where('status', 5)->count(),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    public function tabThuChi(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->except('old_start', 'old_end');
        $input_old = [
            'branch_id' => $request->branch_id,
            'start_date' => $request->old_start,
            'end_date' => $request->old_end,
        ];
        $docOld = 0;
        $docs = ThuChi::search($input)->select('so_tien');
        if (isset($request->old_start) && isset($request->old_end)) {
            $docOld = ThuChi::search($input_old)->select('id')->sum('so_tien');
        }
        $docs2 = clone $docs;

        $data = [
            'all_total' => $docs->sum('so_tien'),
            'percent' => !empty($docs->count()) && !empty($docOld) ? round(($docs->count() - $docOld) / $docOld * 100, 2) : 0,
            'active' => $docs->where('status', StatusConstant::ACTIVE)->sum('so_tien'),
            'inactive' => $docs2->where('status', StatusConstant::INACTIVE)->sum('so_tien'),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Charts tròn
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusRevenue(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $data = [];
        if ($request->type_api == 1) {
            $statusRevenues = $this->orderDetail->revenueWithSource($input);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $statusRevenues);
        } elseif ($request->type_api == 2) {

            $category = Category::select('id', 'name')->where('type', StatusCode::SERVICE)->get()->map(function ($item) use ($input) {
                $services = Services::select('id')->where('category_id', $item->id)->pluck('id')->toArray();
                $orders = OrderDetail::select('price')->whereIn('booking_id', $services)
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
                    });
                $item->all_total = $orders->sum('price');//da thu trong ky thu thêm
                return $item;
            })->sortByDesc('all_total')->take(5);
//            $category_service = Category::getTotalPrice($input, StatusCode::SERVICE, 5);
            $data = ChartResource::collection($category);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        } elseif ($request->type_api == 3) {

            $category_product = Category::select('id', 'name')->where('type', StatusCode::PRODUCT)->get()->map(function ($item) use ($input) {
                $services = Services::select('id')->where('category_id', $item->id)->pluck('id')->toArray();
                $orders = OrderDetail::select('price')->whereIn('booking_id', $services)
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
                    });
                $item->all_total = $orders->sum('price');//da thu trong ky thu thêm
                return $item;
            })->sortByDesc('all_total')->take(5);
            $data = ChartResource::collection($category_product);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

        } elseif ($request->type_api == 4) {
            $orders = Order::returnRawData($input);
            $orders2 = clone $orders;
            $orders3 = clone $orders;
            $data = [
                [
                    'name' => 'Sản phẩm',
                    'all_total' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
                ],
                [
                    'name' => 'Dịch vụ',
                    'all_total' => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
                ],
                [
                    'name' => 'Sản phẩm & D.vụ',
                    'all_total' => $orders3->where('role_type', StatusCode::COMBOS)->sum('gross_revenue'),
                ],
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        } elseif ($request->type_api == 5) {
            $data = $this->orderService->revenueGenderWithOrders($input);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

        } elseif ($request->type_api == 6) {
            $payment = PaymentHistory::search($input, 'price');
            $paymentNew = clone $payment;
            $paymentNew = $paymentNew->whereHas('order', function ($qr) {
                $qr->where('is_upsale', OrderConstant::NON_UPSALE);
            });
            $paymentOld = $payment->whereHas('order', function ($qr) {
                $qr->where('is_upsale', OrderConstant::IS_UPSALE);
            });
            $data = [
                [
                    'name' => 'Khách hàng mới',
                    'all_total' => $paymentNew->sum('price'),

                ],
                [
                    'name' => 'Khách hàng cũ',
                    'all_total' => $paymentOld->sum('price'),

                ],
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

        } elseif ($request->type_api == 7) {
            $data = $this->customer->countWithStatus($input);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

        } elseif ($request->type_api == 8) {
            $payment = PaymentHistory::search($input, 'price');
            $payment_wallet = PaymentWallet::search($input, 'price');
            $thu = $payment->sum('price') + $payment_wallet->sum('price');
            $chi = ThuChi::search($input)->where('status', UserConstant::ACTIVE)->sum('so_tien');
            $data = [
                [
                    'name' => 'Thực thu',
                    'all_total' => (int)$thu,
                ],
                [
                    'name' => 'Chi',
                    'all_total' => (int)$chi,
                ],
                [
                    'name' => 'Lợi nhuận',
                    'all_total' => (int)$thu - (int)$chi,
                ],
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

        }
    }

    /**
     * Doanh thu năm hiện tại
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function revenueMonth(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $ordersYear = Order::select(\DB::raw('SUM(gross_revenue) as all_total'),\DB::raw('MONTH(created_at) month'))->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
            $q->whereIn('branch_id', $input['group_branch']);
        })->whereYear('created_at', Date::now('Asia/Ho_Chi_Minh')->format('Y'))
        ->groupBy('month')->get()->map(function ($item){
            $item->month = 'T'.$item->month;
            return $item;
        });
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $ordersYear);

    }

    /**
     * Doanh thu theo ngày
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function revevueDays(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $data = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'),
            \DB::raw('SUM(gross_revenue) AS revenue'))
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['group_branch']) && count($input['group_branch']), function ($q) use ($input) {
                $q->whereIn('branch_id', $input['group_branch']);
            })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('payment_date', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            })
            ->whereNotNull('payment_date')->orderBy('payment_date', 'asc')
            ->groupBy('payment_date')->get();
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Doanh thu theo năm
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function revevueBranch(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $request->merge(['type_api' => 'all_branch']);
        $input = $request->except('type_api');
        $data = Branch::select('id', 'name')->get()->map(function ($item) use ($input) {
            $input['branch_id'] = $item->id;
            $payment = PaymentHistory::search($input, 'price');
            $payment_wallet = PaymentWallet::search($input, 'price');
            $thu = $payment->sum('price') + $payment_wallet->sum('price');
            $chi = ThuChi::search($input)->where('status', UserConstant::ACTIVE)->sum('so_tien');
            $item->total = (int)$thu;
            $item->revenue = (int)$chi;
            $item->payment = (int)$thu - (int)$chi;
            return $item;
        })->sortByDesc('payment');

//        $data = Order::returnRawData($input)->select('branch_id', \DB::raw('SUM(all_total) AS total'),
//            \DB::raw('SUM(gross_revenue) AS revenue'))
//            ->groupBy('branch_id')->where('branch_id', '<>', 0)->get()->map(function ($item) use ($input) {
//                $params = $input;
//                $params['branch_id'] = $item->branch_id;
//                $payment = PaymentHistory::search($params, 'price');
//                $item->payment = $payment->sum('price');
//                $item->name = @$item->branch->name;
//                unset($item->branch);
//                return $item;
//            })->sortByDesc('payment');

        $data = ChartResource::collection($data);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }
}
