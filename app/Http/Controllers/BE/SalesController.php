<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Customer;
use App\Models\Department;
use App\Models\GroupComment;
use App\Models\Order;
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
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }

        $users = User::whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->withTrashed()->get()->map(function ($item) use ($request) {
            if ($item->id == 27) {
                $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', getTime($request->data_time))->withTrashed();
                $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('created_at', '<', getTime($request->data_time)[0])->withTrashed();
                $data = Customer::select('id')->where('telesales_id', $item->id)->withTrashed();

                $order = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data->pluck('id')->toArray())->with('orderDetails');
                $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->with('orderDetails');//doanh so
                $order_old = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');

                $item->comment_new = GroupComment::select('id')->whereIn('customer_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count();// trao doi moi
                $item->comment_old = GroupComment::select('id')->whereIn('customer_id', $data_old->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count(); // trao doi cu

                $item->schedules_new = Schedule::select('id')->where('creator_id', $item->id)->whereIn('user_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count();//lich hen
                $item->schedules_old = Schedule::select('id')->where('creator_id', $item->id)->whereIn('user_id', $data_old->pluck('id')->toArray())->whereBetween('date', getTime($request->data_time))->get()->count();//lich hen

                $item->customer_new = $data_new->get()->count();
                $item->order_new = $order_new->count();
                $item->order_old = $order_old->count();
                $item->revenue_new = $order_new->sum('all_total');
                $item->revenue_old = $order->sum('all_total') - $order_new->sum('all_total');
                $item->payment_revenue = $order->sum('gross_revenue');
                $item->payment_new = $order_new->sum('gross_revenue');//da thu trong ky
                $item->payment_old = $order->sum('gross_revenue') - $order_new->sum('gross_revenue'); //da thu trong ky
//            $item->payment_rest = PaymentHistory::whereBetween('payment_date', getTime($request->data_time))->whereIn('order_id', $order_old->pluck('id')->toArray())->sum('price');//da thu trong ky thu thêm

                $item->revenue_total = $order->sum('all_total');
            }
            return $item;
        })->sortByDesc('revenue_total');
        \View::share([
            'allTotal' => $users->sum('revenue_total'),
            'grossRevenue' => $users->sum('payment_revenue'),
        ]);


        if ($request->ajax()) {
            return view('report_products.ajax_sale', compact('users'));
        }
        return view('report_products.sale', compact('users'));
    }
}
