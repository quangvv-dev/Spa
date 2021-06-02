<?php

namespace App\Http\Controllers\API;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Customer;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use App\Constants\ResponseStatusCode;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $customers = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
        });
        $schedules = Schedule::getBooks($input);
        $groupComment = GroupComment::when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);

        $customers_old = Customer::select('id')->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
            $q->where('branch_id', $input['branch_id']);
        })->when(isset($input['old_start']) && isset($input['old_end']), function ($q) use ($input) {
            $q->whereBetween('created_at', [Functions::yearMonthDay($input['old_start']) . " 00:00:00", Functions::yearMonthDay($input['old_end']) . " 23:59:59"]);
        });

        $data = [
            'customer_new' => $customers->count(),
            'customer_old' => $customers_old->count(),
            'schedules' => $schedules,
            'groupComment' => $groupComment->count(),
            'percent' => !empty($customers->count()) && !empty($customers_old->count()) ? round(($customers->count() - $customers_old->count()) / $customers_old->count() * 100, 2) : 0
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }

    public function orders(Request $request)
    {
        $input = $request->except('type_api');
        $input_old = [
            'branch_id' => $request->branch_id,
            'start_date' => $request->old_start,
            'end_date' => $request->old_start,
        ];
        $wallet = WalletHistory::search($input);
        $orders = Order::returnRawData($input);
        $orders2 = clone $orders;
        $orders_old = Order::returnRawData($input_old);

        if ($request->type_api == 1) {
            $data = [
                'orders_old' => $orders_old->count(),
                'orders' => $orders->count(),
                'percent' => !empty($orders->count()) && !empty($orders_old->count()) ? round(($orders->count() - $orders_old->count()) / $orders_old->count() * 100, 2) : 0,
                'order_product' => $orders->where('role_type', StatusCode::PRODUCT)->count(),
                'order_services' => $orders2->where('role_type', StatusCode::SERVICE)->count(),
                'wallets' => $wallet->count(),

            ];
        } elseif ($request->type_api == 2) {
            $data = [
                'total' => $orders->sum('all_total'),
                'old_total' => $orders_old->sum('all_total'),
                'percent' => !empty($orders->sum('all_total')) && !empty($orders_old->sum('all_total')) ? round(($orders->count() - $orders_old->count()) / $orders_old->count() * 100, 2) : 0,
                'total_product' => $orders->where('role_type', StatusCode::PRODUCT)->sum('all_total'),
                'total_services' => $orders2->where('role_type', StatusCode::SERVICE)->sum('all_total'),
            ];
        } elseif ($request->type_api == 3) {
            $payment = PaymentHistory::search($input);
            $payment_old = PaymentHistory::search($input_old);

            $data = [
                'payment' => $payment->sum('price'),
                'payment_old' => $payment_old->sum('price'),
                'percent' => !empty($payment->sum('price')) && !empty($payment_old->sum('price')) ? round(($payment->sum('price') - $payment_old->sum('price')) / $payment_old->sum('price') * 100, 2) : 0,
                'gross_revenue' => $orders->sum('gross_revenue'),
                'wallet' => $wallet->sum('order_price'),
                'thu_no' => $payment->sum('price') - $orders->sum('gross_revenue'),
                'con_no' => $orders->sum('all_total') - $orders->sum('gross_revenue'),
            ];
        } elseif ($request->type_api == 4) {
            $payment_old = PaymentHistory::search($input_old);
            $payment = PaymentHistory::search($input);
            $payment2 = clone $payment;
            $payment3 = clone $payment;

            $data = [
                'payment' => $payment->sum('price'),
                'percent' => !empty($payment->sum('price')) && !empty($payment_old->sum('price')) ? round(($payment->sum('price') - $payment_old->sum('price')) / $payment_old->sum('price') * 100, 2) : 0,
                'cash' => $payment->where('payment_type', 1)->sum('price'),
                'card' => $payment2->where('payment_type', 2)->sum('price'),
                'wallet_used' => $payment3->where('payment_type', 3)->sum('price'),
            ];
        }

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }


}
