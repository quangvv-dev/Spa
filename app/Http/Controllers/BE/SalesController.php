<?php

namespace App\Http\Controllers\BE;

use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Models\Services;
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
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }

        $users = User::whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
            $orders = Order::select('member_id', 'all_total', 'gross_revenue')
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->with('orderDetails')->whereHas('customer', function ($qr) use ($item) {
                    $qr->where('telesales_id', $item->id);
                });
            $orders2 = clone $orders;
            $order_new = $orders->whereHas('customer', function ($qr) use ($item) {
                $qr->where('old_customer', 0);
            });
            $order_old = $orders2->whereHas('customer', function ($qr) use ($item) {
                $qr->where('old_customer', 1);
            });

            $group_comment = GroupComment::select('id')->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
            $comment_new = clone $group_comment;

            $item->comment_new = $comment_new->whereIn('customer_id', $order_new->pluck('member_id')->toArray())->count();// trao doi moi
            $item->comment_old = $group_comment->whereIn('customer_id', $order_old->pluck('member_id')->toArray())->count(); // trao doi cu

            $schedules = Schedule::select('id')->where('creator_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
            $schedules_den = clone $schedules;
            $schedules_new = clone $schedules;

            $item->schedules_den = $schedules_den->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
            $item->schedules_new = $schedules_new->whereIn('user_id', $order_new->pluck('member_id')->toArray())->count();//lich hen
            $item->schedules_old = $schedules->whereIn('user_id', $order_old->pluck('member_id')->toArray())->count();//lich hen

            $request->merge(['telesales' => $item->id]);
            $detail = PaymentHistory::search($request->all(), 'price');//đã thu trong kỳ

            $item->customer_new = $data_new->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->revenue_new = $order_new->sum('all_total');
            $item->revenue_old = $order_old->sum('all_total');
            $item->payment_revenue = $orders->sum('gross_revenue');
            $item->payment_new = $order_new->sum('gross_revenue');//da thu trong ky
            $item->payment_old = $order_old->sum('gross_revenue'); //da thu trong ky
            $item->revenue_total = $order_new->sum('all_total') + $order_old->sum('all_total');;
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
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        if (!isset($request->branch_id)) {
            $request->merge(['branch_id' => 1]);
        } elseif ($request->branch_id == (-1)) {
            $request->merge(['branch_id' => null]);
        }

        $type = $type == 'products' ? StatusCode::PRODUCT : StatusCode::SERVICE;
        $branchs = Branch::search()->pluck('name', 'id');

        $telesales = User::whereIn('role', [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->pluck('full_name', 'id')->toArray();
        $users = Category::where('type', $type)->get()->map(function ($item) use ($request, $type) {
            $arr_customer = CustomerGroup::select('customer_id')->where('category_id', $item->id);

            $booking = Services::select('id')->where('type', $type)->where('category_id', $item->id)->pluck('id')->toArray();
            $arr_orders = OrderDetail::select('order_id')->whereIn('booking_id', $booking)->pluck('order_id')->toArray();

            $arr_customer = self::searchBranch($arr_customer, $request)->get()->toArray();

            if ($request->telesale_id) {

                $data = Customer::select('id')->whereIn('id', $arr_customer)->where('telesales_id', $request->telesale_id);
                $data = self::searchBranch($data, $request);
                $data2 = clone $data;

                $data_new = $data2->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);

                $schedules_new = Schedule::select('id')->where('creator_id', $request->telesale_id)->whereIn('user_id', $data_new->pluck('id')->toArray())
                    ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
                $schedules_old = Schedule::select('id')->where('creator_id', $request->telesale_id)->whereBetween('date', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                    ->whereHas('customer', function ($qr) {
                        $qr->where('old_customer', 1);
                    });

                $item->schedules_new = self::searchBranch($schedules_new, $request)->get()->count();//lich hen
                $item->schedules_old = self::searchBranch($schedules_old, $request)->get()->count();//lich hen
            } else {
                $data = Customer::select('id')->whereIn('id', $arr_customer);
                $data = self::searchBranch($data, $request);
                $data2 = clone $data;

                $data_new = $data2->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);

                $schedules_new = Schedule::select('id')->whereIn('user_id', $data_new->pluck('id')->toArray())
                    ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"]);
                $schedules_old = Schedule::select('id')->whereBetween('date', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                    ->whereHas('customer', function ($qr) {
                        $qr->where('old_customer', 1);
                    });

                $item->schedules_new = self::searchBranch($schedules_new, $request)->get()->count();//lich hen
                $item->schedules_old = self::searchBranch($schedules_old, $request)->get()->count();//lich hen
            }

            $order = Order::select('all_total', 'gross_revenue')->whereIn('id', $arr_orders)
                ->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])->with('orderDetails');
            $order = self::searchBranch($order, $request);

            $order_ds = clone $order;
            $order_ds2 = clone $order;

            $order_new = $order_ds->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 0);
            });

            $order_old = $order_ds2->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 1);
            });

            $comment = GroupComment::select('id')->whereBetween('created_at', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->whereIn('customer_id', $arr_customer);
            $comment2 = clone $comment;

            $comment_new = $comment->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 0);
            });
            $comment_old = $comment2->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 1);
            });

            $item->comment_new = self::searchBranch($comment_new, $request)->get()->count();// trao doi moi
            $item->comment_old = self::searchBranch($comment_old, $request)->get()->count(); // trao doi cu

            $payment_history = PaymentHistory::select('price')
                ->whereBetween('payment_date', [Functions::yearMonthDay($request->start_date) . " 00:00:00", Functions::yearMonthDay($request->end_date) . " 23:59:59"])
                ->whereHas('order', function ($qr) use ($request) {
                    $qr->whereDate('created_at', '<', Functions::yearMonthDay($request->start_date) . " 00:00:00");
                });
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
