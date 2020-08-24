<?php

namespace App\Http\Controllers\API;

use App\Constants\StatusCode;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Status;
use App\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Category;
use App\Helpers\Functions;
use App\Constants\UserConstant;
use App\Models\GroupComment;

class StatisticController extends BaseApiController
{
    private $customer;

    /**
     * StatisticController constructor.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $user = User::get()->pluck('full_name', 'id')->toArray();
        $this->customer = $customer;
        view()->share([
            'user' => $user,
        ]);
    }

    /**
     * Thống kê hệ thống
     *
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $input = $request->all();
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }

        $customers = Customer::select('id')->whereBetween('created_at', getTime($input['data_time']));
        $payment = PaymentHistory::search($input);

        $orders = Order::returnRawData($input);
        $orders2 = Order::returnRawData($input);

        $arr = Services::getIdServiceType();
        $input['list_booking'] = $arr;
        $statusRevenues = Status::getRevenueSource($input);

        $category_service = Category::getTotalPrice($input, StatusCode::SERVICE, 5)->toArray();
        $category_product = OrderDetail::getTotalPriceBookingId($input, StatusCode::PRODUCT, 5)->toArray();

        $revenue_month = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'), \DB::raw('SUM(gross_revenue) AS revenue'))->whereBetween('payment_date', getTime($input['data_time']))
            ->whereNotNull('payment_date')->orderBy('payment_date', 'asc')->groupBy('payment_date')->get();


        $data = [
            'all_total' => $orders->sum('all_total'),
            'gross_revenue' => $orders->sum('gross_revenue'),
            'payment' => $payment->sum('price'),
            'orders' => $orders->count(),
            'customers' => $customers->count(),
            'category_service' => array_values($category_service),
            'category_product' => array_values($category_product),
            'revenue_month' => $revenue_month,
        ];
        $products = [
            'orders' => $orders->where('role_type', StatusCode::PRODUCT)->count(),
            'all_total' => $orders->where('role_type', StatusCode::PRODUCT)->sum('all_total'),
            'gross_revenue' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
            'the_rest' => $orders->where('role_type', StatusCode::PRODUCT)->sum('the_rest'),
        ];
        $services = [
            'orders' => $orders2->where('role_type', StatusCode::SERVICE)->get()->count(),
            'all_total' => $orders2->where('role_type', StatusCode::SERVICE)->sum('all_total'),
            'gross_revenue' => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
            'the_rest' => $orders2->where('role_type', StatusCode::SERVICE)->sum('the_rest'),
        ];

        $response = [
            'data' => $data,
            'products' => $products,
            'services' => $services,
            'statusRevenues' => array_values($statusRevenues),
        ];

        return $this->responseApi(200, 'SUCCESS', $response);

    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }

    /**
     * Doanh so, da thu trong ky
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBranch(Request $request)
    {
        $input = $request->all();
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        $payment = PaymentHistory::search($input);
        $orders = Order::returnRawData($input);
        $orders2 = Order::returnRawData($input);
        $revenue_month = Order::select('payment_date', \DB::raw('SUM(all_total) AS total'), \DB::raw('SUM(gross_revenue) AS revenue'))
            ->when(isset($input['data_time']) && $input['data_time'], function ($query) use ($input) {
                $query->whereBetween('payment_date', getTime($input['data_time']));
            })->when(!empty($request->end_date) && !empty($request->start_date), function ($query) use ($input) {
                $query->whereBetween('payment_date', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            })->whereNotNull('payment_date')->orderBy('payment_date', 'asc')->groupBy('payment_date')->get();
        $total = [];
        $revenue = [];
        foreach ($revenue_month as $item) {
            $total[$item->payment_date] = (int)$item->total;
            $revenue[$item->payment_date] = (int)$item->revenue;
        }

        $customers = Customer::select('id')
            ->when(isset($input['data_time']) && $input['data_time'], function ($query) use ($input) {
                $query->whereBetween('created_at', getTime($input['data_time']));
            })->when(!empty($request->end_date) && !empty($request->start_date), function ($query) use ($input) {
                $query->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
            });
        $data = [
            'all_total' => $orders->sum('all_total'),
            'gross_revenue' => $orders->sum('gross_revenue'),
            'payment' => $payment->sum('price'),
            'orders' => $orders->count(),
            'customers' => $customers->count(),
            'revenue_products' => $orders->where('role_type', StatusCode::PRODUCT)->sum('gross_revenue'),
            'revenue_services' => $orders2->where('role_type', StatusCode::SERVICE)->sum('gross_revenue'),
            'revenue_month' => $revenue,
            'total_month' => $total,
        ];

        return $this->responseApi(200, 'SUCCESS', $data);
    }

    /**
     * Thống kê sales
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sales(Request $request)
    {
        $input = $request->all();
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        $users = User::select('id', 'full_name', 'phone')->whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request, $input) {
            if (isset($input['data_time']) && $input['data_time']) {
                $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', getTime($input['data_time']));
                $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('created_at', '<', getTime($request->data_time)[0]);
                $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', getTime($input['data_time']))->with('orderDetails');
                $order_old = Order::whereBetween('created_at', getTime($request->data_time))->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');
                $comment = GroupComment::select('id')->where('user_id', $item->id)->whereBetween('created_at', getTime($input['data_time']))->get()->count();// trao doi
            } else {
                $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"]);
                $order_new = Order::whereIn('member_id', $data_new->pluck('id')->toArray())->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])->with('orderDetails');
                $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('created_at', '<', Functions::yearMonthDay($input['start_date']));
                $order_old = Order::whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])->whereIn('member_id', $data_old->pluck('id')->toArray())->with('orderDetails');
                $comment = GroupComment::select('id')->where('user_id', $item->id)->whereBetween('created_at', [Functions::yearMonthDay($input['start_date']) . " 00:00:00", Functions::yearMonthDay($input['end_date']) . " 23:59:59"])->get()->count();// trao doi
            }

            $item->comment = $comment;
            $item->customer_new = $data_new->get()->count();
            $item->order_new = $order_new->count();
            $item->payment_new = $order_new->sum('gross_revenue') + $order_old->sum('gross_revenue');//da thu trong ky
            $item->gross_revenue = $order_new->sum('gross_revenue');//doanh thu
            $item->all_total = $order_new->sum('all_total');//doanh so
            return $item;
        })->sortByDesc('gross_revenue');

        return $this->responseApi(200, 'SUCCESS', $users);
    }

    /**
     * Sale with branch
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saleWithBranch(Request $request)
    {
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }

        $users = User::whereIn('role', [UserConstant::TELESALES, UserConstant::WAITER])->get()->map(function ($item) use ($request) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereBetween('created_at', getTime($request->data_time));
            $data_old = Customer::select('id')->where('telesales_id', $item->id)->where('created_at', '<', getTime($request->data_time)[0]);
            $data = Customer::select('id')->where('telesales_id', $item->id);

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
            return $item;
        })->sortByDesc('revenue_total');

        return $this->responseApi(200, 'SUCCESS', $users);

    }
}
