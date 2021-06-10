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
        $schedules = Schedule::getBooks($input);
        $groupComment = GroupComment::when(isset($input['branch_id']) && $input['branch_id'],
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
        $history = HistoryUpdateOrder::when(isset($input['start_date']) && isset($input['end_date']),
            function ($q) use ($input) {
                $q->whereBetween('created_at', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            });
        $data = [
            'customer_new' => $customers->count(),
            'schedules'    => $schedules,
            'groupComment' => $groupComment->count(),
            'become'       => $history->count(),
            'percent'      => !empty($customers->count()) && (isset($customers_old) && !empty($customers_old->count())) ? round(($customers->count() - $customers_old->count()) / $customers_old->count() * 100,
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
            'branch_id'  => $request->branch_id,
            'start_date' => $request->old_start,
            'end_date'   => $request->old_start,
        ];
        $wallet = WalletHistory::search($input);
        $orders = Order::returnRawData($input);
        $orders2 = clone $orders;
        $orders_old = [];
        $payment_old = [];
        if (isset($input_old['start_date']) && isset($input_old['end_date'])) {
            $orders_old = Order::returnRawData($input_old);
        }
        if ($request->type_api == 1) {
            $orders_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $orders_old->count() : 0;
            $data = [
                'orders'         => $orders->count(),
                'percent'        => !empty($orders->count()) && !empty($orders_old) ? round(($orders->count() - $orders_old) / $orders_old * 100,
                    2) : 0,
                'order_product'  => $orders->where('role_type', StatusCode::PRODUCT)->count(),
                'order_services' => $orders2->where('role_type', StatusCode::SERVICE)->count(),
                'wallets'        => $wallet->count(),
            ];
        } elseif ($request->type_api == 2) {
            $orders_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $orders_old->sum('all_total') : 0;

            $data = [
                'total'          => $orders->sum('all_total'),
                'percent'        => !empty($orders->sum('all_total')) && !empty($orders_old) ? round(($orders->count() - $orders_old) / $orders_old * 100,
                    2) : 0,
                'total_product'  => $orders->where('role_type', StatusCode::PRODUCT)->sum('all_total'),
                'total_services' => $orders2->where('role_type', StatusCode::SERVICE)->sum('all_total'),
            ];
        } elseif ($request->type_api == 3) {
            $payment = PaymentHistory::search($input);
            if (isset($input_old['start_date']) && isset($input_old['end_date'])) {
                $payment_old = PaymentHistory::search($input_old);
            }
            $payment_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $payment_old->sum('price') : 0;

            $data = [
                'payment'       => $payment->sum('price'),
                'percent'       => !empty($payment->sum('price')) && !empty($payment_old) ? round(($payment->sum('price') - $payment_old) / $payment_old * 100,
                    2) : 0,
                'gross_revenue' => $orders->sum('gross_revenue'),
                'wallet'        => $wallet->sum('order_price'),
                'thu_no'        => $payment->sum('price') - $orders->sum('gross_revenue'),
                'con_no'        => $orders->sum('all_total') - $orders->sum('gross_revenue'),
            ];
        } elseif ($request->type_api == 4) {
            if (isset($input_old['start_date']) && isset($input_old['end_date'])) {
                $payment_old = PaymentHistory::search($input_old);
            }
            $payment_old = isset($input_old['start_date']) && isset($input_old['end_date']) ? $payment_old->sum('price') : 0;

            $payment = PaymentHistory::search($input);
            $payment2 = clone $payment;
            $payment3 = clone $payment;

            $data = [
                'payment'     => $payment->sum('price'),
                'percent'     => !empty($payment->sum('price')) && !empty($payment_old) ? round(($payment->sum('price') - $payment_old) / $payment_old * 100,
                    2) : 0,
                'cash'        => $payment->where('payment_type', 1)->sum('price'),
                'card'        => $payment2->where('payment_type', 2)->sum('price'),
                'wallet_used' => $payment3->where('payment_type', 3)->sum('price'),
            ];
        }

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
            $statusRevenues = Status::getRevenueSource($input);
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', array_values($statusRevenues));
        } elseif ($request->type_api == 2) {
            $category_service = Category::getTotalPrice($input, StatusCode::SERVICE, 5);
            $data = ChartResource::collection($category_service);
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
                    'name'      => 'Sản phẩm',
                    'all_total' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
                ],
                [
                    'name'      => 'Dịch vụ',
                    'all_total' => $orders2->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
                ],
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        } elseif ($request->type_api == 5) {
            $revenue_gender = [];
            $orders = Order::returnRawData($input)->get();;
            if (count($orders)) {
                foreach ($orders as $item) {
                    if (isset($item->customer->gender) && $item->customer->gender) {
                        $revenue_gender[$item->customer->gender][] = !empty($item->gross_revenue) ? $item->gross_revenue : 0;
                    }
                }
                if (count($revenue_gender)) {
                    foreach ($revenue_gender as $k => $item) {
                        $data[] = [
                            'name'      => $k == 0 ? 'Nữ' : 'Nam',
                            'all_total' => array_sum($item),
                        ];
                    }
                }
            }
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        } elseif ($request->type_api == 6) {
            $payment = PaymentHistory::search($input);
            $orders = Order::returnRawData($input);
            $orders_old = clone $orders->whereHas('customer', function ($q) {
                $q->where('old_customer', 1);
            });
            $orders_new = clone $orders->whereHas('customer', function ($q) {
                $q->where('old_customer', 0);
            });
            $data = [
                [
                    'name'      => 'Khách hàng mới',
                    'all_total' => $orders_new->sum('gross_revenue'),

                ],
                [
                    'name'      => 'Khách hàng cũ',
                    'all_total' => $orders_old->sum('gross_revenue'),

                ],
                [
                    'name'      => 'Thu còn nợ',
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
        $ordersYear = Order::when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->whereYear('created_at', Date::now('Asia/Ho_Chi_Minh')->format('Y'));

        for ($i = 1; $i <= 12; $i++) {
            $newOrder = clone $ordersYear;
            $newOrder = $newOrder->whereMonth('created_at', $i)->sum('gross_revenue');

            $data[] = [
                'month'     => 'T' . $i,
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
            ->groupBy('branch_id')->get()->map(function ($item) use ($input) {
                $params = $input;
                $params['branch_id'] = $item->branch_id;
                $payment = PaymentHistory::search($params);
                $item->payment = $payment->sum('price');
                $item->name = @$item->branch->name;
                unset($item->branch);
                return $item;
            })->sortByDesc('payment');
        $data = ChartResource::collection($data);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }
}
