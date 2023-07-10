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
        //
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
        foreach ($branch as $item) {
            $input['branch_id'] = $item->id;
            $payment = PaymentHistory::search($input, 'price');
            $orders = Order::returnRawData($input);
            $wallet = WalletHistory::search($input, 'order_price,payment_type,price');

            $data = [
                'all_total' => $orders->sum('all_total'),
                'gross_revenue' => $orders->sum('gross_revenue'),
                'payment' => $payment->sum('price'),
            ];
            $wallets = [
                'revenue' => $wallet->sum('order_price'),
                'used' => $data['payment'] - $payment->where('payment_type', 3)->sum('price'),
            ];
            $result[] = [
                'branch' => $item->name,
                'all_total' => $data['all_total'] + $wallets['revenue'],
                'gross_revenue' => $data['gross_revenue'],
                'payment' => $data['payment'] + $wallets['revenue'] - $wallets['used'],
            ];
            usort($result, function ($a, $b) {
                return $b['payment'] <=> $a['payment'];
            });
        }
        if ($request->ajax()) {
            return view('chart_revenue.ajax', compact('result'));
        }

        return view('chart_revenue.index', compact('title', 'result'));
    }
}
