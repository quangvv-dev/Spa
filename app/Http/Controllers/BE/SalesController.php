<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Customer;
use App\Models\Department;
use App\Models\GroupComment;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\TaskService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SalesController extends Controller
{
    private $taskService;

    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {

    }

    public function index(Request $request)
    {
        $now = Carbon::now();
        $current_year = $now->format('Y');
        if ($request->data_time == 'LAST_MONTH') {
            $current_month = Carbon::today()->subMonth()->startOfMonth()->format('m');
        } else {
            $current_month = $now->format('m');
        }

        $users = User::where('role', UserConstant::TELESALES)->get()->map(function ($item) use ($current_month, $current_year) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereMonth('created_at', $current_month)
                ->whereYear('created_at', $current_year);
            $data_old = Customer::select('id')->where('telesales_id', $item->id)->whereMonth('created_at', '<=', $current_month)
                ->whereYear('created_at', $current_year);
            $order_new = OrderDetail::whereIn('user_id', $data_new->pluck('id')->toArray());//doanh so
            $order_old = OrderDetail::whereMonth('created_at', $current_month)
                ->whereYear('created_at', $current_year)->whereIn('user_id', $data_old->pluck('id')->toArray());
            $order_old_before = OrderDetail::whereMonth('created_at', '<', $current_month)
                ->whereYear('created_at', $current_year)->whereIn('user_id', $data_old->pluck('id')->toArray())
                ->groupBy('order_id')->pluck('order_id')->toArray();

            $item->comment_new = GroupComment::select('id')->whereIn('customer_id', $data_new->pluck('id')->toArray())->whereMonth('created_at', $current_month)
                ->whereYear('created_at', $current_year)->get()->count();// trao doi moi
            $item->comment_old = GroupComment::select('id')->whereIn('customer_id', $data_old->pluck('id')->toArray())->whereMonth('created_at', $current_month)
                ->whereYear('created_at', $current_year)->get()->count(); // trao doi cu
            $item->schedules_new = Schedule::select('id')->whereIn('user_id', $data_new->pluck('id')->toArray())->whereMonth('created_at', $current_month)
                ->whereYear('created_at', $current_year)->get()->count();//lich hen
            $item->customer_new = $data_new->get()->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->revenue_new = $order_new->sum('total_price');
            $item->revenue_old = $order_old->sum('total_price');
            $arr_order_new = $order_new->groupBy('order_id')->pluck('order_id')->toArray();
            $arr_order_old = $order_old->groupBy('order_id')->pluck('order_id')->toArray();
            $item->payment_new = PaymentHistory::whereIn('order_id', $arr_order_new)->sum('price');//da thu trong ky
            $item->payment_old = PaymentHistory::whereIn('order_id', $arr_order_old)->whereMonth('payment_date', $current_month)
                ->whereYear('payment_date', $current_year)->sum('price'); //da thu trong ky
            $item->payment_rest = PaymentHistory::whereMonth('payment_date', $current_month)
                ->whereYear('payment_date', $current_year)->whereIn('order_id', $order_old_before)->sum('price');//da thu trong ky thu thêm

            $item->revenue_total = (int)$item->revenue_new + (int)$item->revenue_old;
            return $item;
        })->sortByDesc('revenue_total');
//        dd($users);
        if ($request->ajax()) {
            return view('report_products.ajax_sale', compact('users'));
        }
        return view('report_products.sale', compact('users'));
    }
}
