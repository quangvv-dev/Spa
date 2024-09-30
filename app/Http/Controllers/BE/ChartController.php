<?php

namespace App\Http\Controllers\BE;

use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:report.chart-revenue', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $title = 'Thống kê doanh thu';
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }

        $branch = Branch::get();

        $input = $request->all();
        $result = [];
        $branchs = [];
        $all_totals = [];
        $gross_revenues = [];
        $payments = [];
        foreach ($branch as $item) {
            $input['branch_id'] = $item->id;
            $payment = PaymentHistory::search($input, 'price');
            $payment2 = clone $payment;
            $payment3 = clone $payment;
            $orders = Order::returnRawData($input);
            $wallet = WalletHistory::search($input, 'order_price,payment_type,price');

            $data = [
                'all_total' => $orders->sum('all_total'),
                'gross_revenue' => $orders->sum('gross_revenue'),
                'payment' => $payment->sum('price'),
            ];
            $list_payment = [
                'money' => $payment2->where('payment_type', 1)->sum('price'),
                'card' => $payment3->where('payment_type', 2)->sum('price'),
                'CK' => $payment->where('payment_type', 4)->sum('price'),
            ];
            $wallets = [
                'revenue' => $wallet->sum('order_price'),
                'used' => $data['payment'] - $list_payment['money'] - $list_payment['card'] - $list_payment['CK'],
            ];
            $branchs[] = $item->name;
            $all_totals[] = $data['all_total'] + $wallets['revenue'];
            $gross_revenues[] = $data['gross_revenue'];
            $payments[] = $data['payment'] + $wallets['revenue'] - $wallets['used'];
//            $result[] = [
//                'branch' => $item->name,
//                'all_total' => $data['all_total'] + $wallets['revenue'],
//                'gross_revenue' => $data['gross_revenue'],
//                'payment' => $data['payment'] + $wallets['revenue'] - $wallets['used'],
//            ];
//            usort($result, function ($a, $b) {
//                return $b['payment'] <=> $a['payment'];
//            });
        }
        $branchs = array_map(function($item) {
            return "'$item'";
        }, $branchs);

        $branchs = implode(',', $branchs);
        $all_totals = count($all_totals)? implode(", ", $all_totals) : 0;
        $gross_revenues = count($gross_revenues)? implode(", ", $gross_revenues): 0;
        $payments = count($payments)? implode(", ", $payments) : 0;
        if ($request->ajax()) {
            return view('chart_revenue.ajax', compact('branchs', 'all_totals', 'gross_revenues', 'payments'));
        }

        return view('chart_revenue.index', compact('title', 'branchs', 'all_totals', 'gross_revenues', 'payments'));
    }
}
