<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Services\TaskService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Dompdf\Dompdf;

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
        $this->middleware('permission:report.groupSale', ['only' => ['indexGroupCategory']]);
        $this->middleware('permission:report.sale', ['only' => ['index']]);

    }

    /**
     * Bảng xếp hạng sales
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }

        $users = User::whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)->where('old_customer', 0)->whereBetween('created_at', getTime($request->data_time));
            $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('old_customer', 1);
            $data = Customer::select('id')->where('telesales_id', $item->id);

            $order = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data->pluck('id')->toArray())->with('orderDetails');
            $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->with('orderDetails');//doanh so
            $order_old = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');

            $item->comment_new = GroupComment::select('id')->whereIn('customer_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count();// trao doi moi
            $item->comment_old = GroupComment::select('id')->whereIn('customer_id', $data_old->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count(); // trao doi cu

            $item->schedules_new = Schedule::select('id')->where('creator_id', $item->id)->whereIn('user_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->get()->count();//lich hen
            $item->schedules_old = Schedule::select('id')->where('creator_id', $item->id)->whereIn('user_id', $data_old->pluck('id')->toArray())->whereBetween('date', getTime($request->data_time))->get()->count();//lich hen

            $request->merge(['telesales' => $item->id]);
            $detail = PaymentHistory::search($request->all());

            $item->customer_new = $data_new->get()->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->revenue_new = $order_new->sum('all_total');
            $item->revenue_old = $order->sum('all_total') - $order_new->sum('all_total');
            $item->payment_revenue = $order->sum('gross_revenue');
            $item->payment_new = $order_new->sum('gross_revenue');//da thu trong ky
            $item->payment_old = $order->sum('gross_revenue') - $order_new->sum('gross_revenue'); //da thu trong ky
            $item->revenue_total = $order->sum('all_total');
            $item->all_payment = $detail->sum('price');
            return $item;
        })->sortByDesc('all_payment');
        \View::share([
            'allTotal' => $users->sum('revenue_total'),
            'grossRevenue' => $users->sum('payment_revenue'),
        ]);

        if (!empty($request->dowload_pdf)) {
            $pdf = \PDF::loadView('report_products.sale_pdf', compact('users'))->setPaper('A3', 'landscape');
            return $pdf->download('sale.pdf');
        }
        if ($request->ajax()) {
            return view('report_products.ajax_sale', compact('users'));
        }
        return view('report_products.sale', compact('users'));
    }


    public function indexGroupCategory(Request $request, $type)
    {
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_WEEK']);
        }
        $type = $type == 'products' ? StatusCode::PRODUCT : StatusCode::SERVICE;
        $branchs = Branch::search()->pluck('name', 'id');

        $telesales = User::whereIn('role', [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->pluck('full_name', 'id')->toArray();
        $users = Category::where('type', $type)->get()->map(function ($item) use ($request) {
            $arr_customer = CustomerGroup::where('category_id', $item->id)->pluck('customer_id')->toArray();

            if ($request->telesale_id) {
                $data_new = Customer::select('id')->whereIn('id', $arr_customer)->where('telesales_id', $request->telesale_id)->whereBetween('created_at', getTime($request->data_time));
                $data_new = self::searchBranch($data_new, $request);

                $data_old = Customer::select('id')->whereIn('id', $arr_customer)->where('telesales_id', $request->telesale_id)->where('created_at', '<', getTime($request->data_time)[0]);
                $data_old = self::searchBranch($data_old, $request);

                $data = Customer::select('id')->whereIn('id', $arr_customer)->where('telesales_id', $request->telesale_id);
                $data = self::searchBranch($data, $request);

                $schedules_new = Schedule::select('id')->where('creator_id', $request->telesale_id)->whereIn('user_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time));
                $schedules_old = Schedule::select('id')->where('creator_id', $request->telesale_id)->whereIn('user_id', $data_old->pluck('id')->toArray())->whereBetween('date', getTime($request->data_time));

                $item->schedules_new = self::searchBranch($schedules_new, $request)->get()->count();//lich hen
                $item->schedules_old = self::searchBranch($schedules_old, $request)->get()->count();//lich hen
            } else {
                $data_new = Customer::select('id')->whereIn('id', $arr_customer)->whereBetween('created_at', getTime($request->data_time));
                $data_new = self::searchBranch($data_new, $request);

                $data_old = Customer::select('id')->whereIn('id', $arr_customer)->where('created_at', '<', getTime($request->data_time)[0]);
                $data_old = self::searchBranch($data_old, $request);

                $data = Customer::select('id')->whereIn('id', $arr_customer);
                $data = self::searchBranch($data, $request);
                $schedules_new = Schedule::select('id')->whereIn('user_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time));
                $schedules_old = Schedule::select('id')->whereIn('user_id', $data_old->pluck('id')->toArray())->whereBetween('date', getTime($request->data_time));

                $item->schedules_new = self::searchBranch($schedules_new, $request)->get()->count();//lich hen
                $item->schedules_old = self::searchBranch($schedules_old, $request)->get()->count();//lich hen
            }

            $orderLast = Order::whereDate('created_at', '<', getTime($request->data_time)[0])->whereIn('member_id', $data->pluck('id')->toArray())->with('orderDetails');
            $orderLast = self::searchBranch($orderLast, $request);

            $order = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data->pluck('id')->toArray())->with('orderDetails');
            $order = self::searchBranch($order, $request);

            $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time))->with('orderDetails');//doanh so
            $order_new = self::searchBranch($order_new, $request);

            $order_old = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');
            $order_old = self::searchBranch($order_old, $request);

            $comment_new = GroupComment::select('id')->whereIn('customer_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time));
            $comment_old = GroupComment::select('id')->whereIn('customer_id', $data_old->pluck('id')->toArray())->whereBetween('created_at', getTime($request->data_time));

            $item->comment_new = self::searchBranch($comment_new, $request)->get()->count();// trao doi moi
            $item->comment_old = self::searchBranch($comment_old, $request)->get()->count(); // trao doi cu

            $payment_history = PaymentHistory::whereBetween('payment_date', getTime($request->data_time))->whereIn('order_id', $orderLast->pluck('id')->toArray());
            $payment_history = self::searchBranch($payment_history, $request);

            $item->customer_new = $data_new->get()->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->revenue_new = $order_new->sum('all_total');
            $item->revenue_old = $order->sum('all_total') - $order_new->sum('all_total');
            $item->payment_revenue = $order->sum('gross_revenue');
            $item->payment_new = $order_new->sum('gross_revenue');//da thu trong ky
            $item->payment_old = $order->sum('gross_revenue') - $order_new->sum('gross_revenue'); //da thu trong ky
            $price = $payment_history->sum('price');//da thu trong ky thu thêm
            $item->payment_rest = $price;
            $item->revenue_total = $order->sum('all_total');
            return $item;
        })->sortByDesc('revenue_total');
        \View::share([
            'allTotal' => $users->sum('revenue_total'),
            'grossRevenue' => $users->sum('payment_revenue'),
        ]);

        if (!empty($request->dowload_pdf)) {
            $pdf = \PDF::loadView('report_products.category_pdf', compact('users', 'telesales'))->setPaper('A4', 'landscape');
            return $pdf->download('category_report.pdf');
        }
        if ($request->ajax()) {
            return view('report_products.ajax_group', compact('users', 'telesales'));
        }
        return view('report_products.group_sale', compact('branchs', 'users', 'telesales'));
    }

    public function searchBranch($query, $input)
    {
        return $query->when(isset($input->branch_id) && $input->branch_id, function ($q) use ($input) {
            $q->where('branch_id', $input->branch_id);
        });
    }
}
