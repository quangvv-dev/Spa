<?php

namespace App\Http\Controllers\BE;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ChartController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $total = [];
        $tmp = [];
        $total2 = [];
        $tmp2 = [];
        $docs = Customer::orderBy('id', 'desc')->with('category')->with('orders')->get();
        if (count($docs)) {
            foreach ($docs as $item) {
                $num = count($item->orders);
                if (!empty($item->category) && (int)$num >= 1) {
                    foreach ($item->orders as $order) {
                        $total[$item->category->name] = $order->all_total;
                    };
                    $tmp[$item->category->name] = [
                        $item->category->name => array_sum($total),
                    ];
                }
            }
        }
        //Thống kê nhóm KH
        $docs2 = Customer::orderBy('id', 'desc')->with('source_customer')->with('orders')->get();
        if (count($docs2)) {
            foreach ($docs2 as $item) {
                $num = count($item->orders);
                if (!empty($item->source_customer) && (int)$num >= 1) {
                    foreach ($item->orders as $order) {
                        $total2[$item->source_customer->name] = $order->all_total;
                    };
                    $tmp2[$item->source_customer->name] = [
                        $item->source_customer->name => array_sum($total),
                    ];
                }
            }
        }
//        if ($request->search) {
//            $docs = $docs->where('name', 'like', '%' . $request->search . '%')
//                ->orwhere('code', 'like', '%' . $request->search . '%')
//                ->orwhere('parent_id', 'like', '%' . $request->search . '%');
//        }
        $title = 'Thống kê doanh thu';
//        if ($request->ajax()) {
//            return Response::json(view('chart_revenue.ajax', compact('title', 'tmp'))->render());
//        }
        return view('chart_revenue.index', compact('title', 'tmp', 'tmp2'));
    }
}
