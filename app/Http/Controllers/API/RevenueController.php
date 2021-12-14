<?php

namespace App\Http\Controllers\API;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Http\Resources\ChartResource;
use App\Models\Category;
use App\Models\Customer;
use App\Models\GroupComment;
use App\Models\HistoryUpdateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Models\Services;
use App\Models\Status;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use App\Constants\ResponseStatusCode;
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Expr\Clone_;

class RevenueController extends BaseApiController
{

    /**
     * StatisticController constructor.
     *
     * @param Customer $customer
     */
    public function __construct()
    {
        //code
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
        $input = $request->all();
        $customers = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'],
            function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        });
        $schedules = Schedule::getBooks($input, 'id');
        $groupComment = GroupComment::select('id')->when(isset($input['branch_id']) && $input['branch_id'],
            function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->whereBetween('created_at', [
            Functions::yearMonthDay($input['start_date']) . " 00:00:00",
            Functions::yearMonthDay($input['end_date']) . " 23:59:59",
        ]);
        if (isset($input['old_start']) && isset($input['old_end'])) {
            $customers_old = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'],
                function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->whereBetween('created_at', [
                Functions::yearMonthDay($input['old_start']) . " 00:00:00",
                Functions::yearMonthDay($input['old_end']) . " 23:59:59",
            ]);
        }
        $history = HistoryUpdateOrder::select('id')->when(isset($input['branch_id']) && $input['branch_id'],
                function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })
            ->when(isset($input['start_date']) && isset($input['end_date']),
            function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            });
        $data = [
            'customer_new' => $customers->count(),
            'schedules' => $schedules,
            'groupComment' => $groupComment->count(),
            'become' => $history->count(),
            'percent' => !empty($customers->count()) && (isset($customers_old) && !empty($customers_old->count())) ? round(($customers->count() - $customers_old->count()) / $customers_old->count() * 100,
                2) : 0,
        ];
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
        $input = $request->except('type_api');
        $input_old = [
            'branch_id' => $request->branch_id,
            'start_date' => $request->old_start,
            'end_date' => $request->old_end,
        ];
        $wallet = WalletHistory::search($input, 'order_price');
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
                'orders' => $orders->count(),
                'percent' => !empty($orders->count()) && !empty($orders_old) ? round(($orders->count() - $orders_old) / $orders_old * 100,
                    2) : 0,
                'order_product' => $orders->where('role_type', StatusCode::PRODUCT)->count(),
                'order_services' => $orders2->where('role_type', StatusCode::SERVICE)->count(),
                'wallets' => $wallet->count(),
            ];
        } elseif ($request->type_api == 2) {
            $orders_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $orders_old->sum('all_total') : 0;

            $data = [
                'total' => $orders->sum('all_total')+$wallet->sum('order_price'),
                'percent' => !empty($orders->sum('all_total')) && !empty($orders_old) ? round(($orders->count() - $orders_old) / $orders_old * 100,
                    2) : 0,
                'total_product' => $orders->where('role_type', StatusCode::PRODUCT)->sum('all_total'),
                'total_services' => $orders2->where('role_type', StatusCode::SERVICE)->sum('all_total'),
                'total_combo' => $orders_combo->where('role_type', StatusCode::SERVICE)->sum('all_total'),
                'wallet' => $wallet->sum('order_price'),
            ];
        } elseif ($request->type_api == 3) {
            $payment = PaymentHistory::search($input, 'price');
            if (isset($input_old['start_date']) && isset($input_old['end_date'])) {
                $payment_old = PaymentHistory::search($input_old, 'price');
            }
            $payment_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $payment_old->sum('price') : 0;

            $data = [
                'payment' => $payment->sum('price'),
                'percent' => !empty($payment->sum('price')) && !empty($payment_old) ? round(($payment->sum('price') - $payment_old) / $payment_old * 100,
                    2) : 0,
                'gross_revenue' => $orders->sum('gross_revenue'),
                'wallet' => $wallet->sum('order_price'),
                'thu_no' => $payment->sum('price') - $orders->sum('gross_revenue'),
                'con_no' => $orders->sum('all_total') - $orders->sum('gross_revenue'),
            ];
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
                'payment' => (int)$payment->sum('price'),
                'percent' => !empty($all_payment) && !empty($payment_old) ? round(($all_payment - $payment_old) / $payment_old * 100,
                    2) : 0,
                'cash' => (int)$payment->whereIn('payment_type', [0, 1])->sum('price'),
                'card' => (int)$payment2->where('payment_type', 2)->sum('price'),
                'wallet_used' => $payment3->where('payment_type', 3)->sum('price'),
                'wallet' => $wallet->sum('order_price'),
            ];
            $data['CK'] = $all_payment - $data['cash'] - $data['card'] - $data['wallet_used'];
        }

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    /**
     * Tab Schedules
     *
     * @param Request $request
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

    /**
     * Charts tròn
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusRevenue(Request $request)
    {
        $input = $request->all();
        $data = [];
        if ($request->type_api == 1) {
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
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', array_values($statusRevenues));
        } elseif ($request->type_api == 2) {


            $category = Category::select('id', 'name')->where('type', StatusCode::SERVICE)->get()->map(function ($item
            ) use ($input) {
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
                    });
                $item->all_total = $orders->sum('price');//da thu trong ky thu thêm
                return $item;
            })->sortByDesc('all_total')->take(5);
//            $category_service = Category::getTotalPrice($input, StatusCode::SERVICE, 5);
            $data = ChartResource::collection($category);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        } elseif ($request->type_api == 3) {
            $category_product = OrderDetail::getTotalPriceBookingId($input, StatusCode::PRODUCT, 5);
            $data = ChartResource::collection($category_product);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        } elseif ($request->type_api == 4) {
            $orders = Order::returnRawData($input);
            $orders2 = clone $orders;
            $data = [
                [
                    'name' => 'Sản phẩm',
                    'all_total' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
                ],
                [
                    'name' => 'Dịch vụ',
                    'all_total' => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
                ],
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        } elseif ($request->type_api == 5) {
            $revenue_gender = [];
            $orders = Order::returnRawData($input)->get();
            if (count($orders)) {
                foreach ($orders as $k => $item) {

                    if (isset($item->customer)) {
                        $revenue_gender[$item->customer->gender][] = !empty($item->gross_revenue) ? $item->gross_revenue : 0;
                    }
                }
                if (count($revenue_gender)) {
                    foreach ($revenue_gender as $k => $item) {
                        $data[] = [
                            'name' => ($k == 0) ? 'Nữ' : 'Nam',
                            'all_total' => array_sum($item),
                        ];
                    }
                }
            }
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        } elseif ($request->type_api == 6) {
            $payment = PaymentHistory::search($input, 'price');
            $orders = Order::returnRawData($input);
            $orders2 = clone $orders;
            $customers = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                    $q->where('branch_id', $input['branch_id']);
                })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            })->pluck('id')->toArray();
            $orders_new = $orders2->whereIn('member_id', $customers);

            $orders_old = $orders->whereHas('customer', function ($q) {
                $q->where('old_customer', 1);
            });
            $data = [
                [
                    'name' => 'Khách hàng mới',
                    'all_total' => $orders_new->sum('gross_revenue'),

                ],
                [
                    'name' => 'Khách hàng cũ',
                    'all_total' => $orders_old->sum('gross_revenue'),

                ],
                [
                    'name' => 'Thu còn nợ',
                    'all_total' => $payment->sum('price') - $orders_new->sum('gross_revenue') - $orders_old->sum('gross_revenue'),

                ],
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

        } elseif ($request->type_api == 7) {
            $customers = Customer::orderByDesc('id');
            $data = Customer::applySearchConditions($customers, $input)->select('id', 'source_id',
                \DB::raw('COUNT(ID) AS total'))->groupBy('source_id')->with('source_customer')->get();
            $data = ChartResource::collection($data);

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
        $input = $request->all();
        $ordersYear = Order::select('gross_revenue')->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->whereYear('created_at', Date::now('Asia/Ho_Chi_Minh')->format('Y'));

        for ($i = 1; $i <= 12; $i++) {
            $newOrder = clone $ordersYear;
            $newOrder = $newOrder->whereMonth('created_at', $i)->sum('gross_revenue');

            $data[] = [
                'month' => 'T' . $i,
                'all_total' => (int)$newOrder,
            ];
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

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
        $input = $request->all();
        $data = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'),
            \DB::raw('SUM(gross_revenue) AS revenue'))
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })
            ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
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
        $request->merge(['type_api' => 'all_branch']);
        $input = $request->except('type_api');
        $data = Order::returnRawData($input)->select('branch_id', \DB::raw('SUM(all_total) AS total'),
            \DB::raw('SUM(gross_revenue) AS revenue'))
            ->groupBy('branch_id')->where('branch_id', '<>', 0)->get()->map(function ($item) use ($input) {
                $params = $input;
                $params['branch_id'] = $item->branch_id;
                $payment = PaymentHistory::search($params, 'price');
                $item->payment = $payment->sum('price');
                $item->name = @$item->branch->name;
                unset($item->branch);
                return $item;
            })->sortByDesc('payment');
        $data = ChartResource::collection($data);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }
}
