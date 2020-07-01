<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
use App\Models\Commission;
use App\Models\Customer;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Schedule;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
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
        if (empty($request->data_time)) {
            $input['data_time'] = 'THIS_MONTH';
        }

        $customers = Customer::select('id')->whereBetween('created_at', getTime($input['data_time']));

        $orders = Order::returnRawData($input);
        $orders2 = Order::returnRawData($input);

        $data = [
            'all_total' => $orders->sum('all_total'),
            'gross_revenue' => $orders->sum('gross_revenue'),
            'the_rest' => $orders->sum('the_rest'),
            'orders' => $orders->count(),
            'customers' => $customers->count(),
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


        if ($request->ajax()) {
            return Response::json(view('statistics.ajax', compact('data', 'services', 'products'))->render());
        }
        return view('statistics.index', compact('data', 'services', 'products'));
    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }
}
