<?php

namespace App\Http\Controllers\API;

use App\Constants\StatusCode;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\Services;
use App\Models\CustomerGroup;
use App\Models\Category;

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

        $data = [
            'all_total' => $orders->sum('all_total'),
            'payment' => $payment->sum('price')
        ];

        return $this->responseApi(200, 'SUCCESS', $data);
    }
}
