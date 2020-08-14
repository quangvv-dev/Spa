<?php

namespace App\Http\Controllers\BE;

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
use nusoap_client;

class StatisticController extends Controller
{
    private $customer;
    protected $tower = [
        'http://spa.test/api/' => 'TEST',
        'https://royalspalh.adamtech.vn/api/' => 'Láng Hạ',
//        'https://royalspabn.adamtech.vn/api/' => 'Bắc Ninh 1',
//        'https://royalspabn2.adamtech.vn/api/' => 'Bắc Ninh 2',
//        'https://royalspabg.adamtech.vn/api/' => 'Bắc Giang',
//        'https://royalspahp.adamtech.vn/api/' => 'Hải Phòng',
//        'https://royalspavp.adamtech.vn/api/' => 'Vĩnh Phúc',
//        'https://royalspatn.adamtech.vn/api/' => 'Thái Nguyên',
//        'https://royalspasg.adamtech.vn/api/' => 'Sài Gòn',
    ];

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
        $towers = $this->tower;
        $input = $request->all();
        if (empty($request->data_time)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        if (empty($request->tower)) {
            $input['tower'] = 'https://royalspabg.adamtech.vn/api/';
        }
        $params = [
            'query' => [
                'data_time' => $input['data_time'],
            ]
        ];
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $input['tower'] . 'statistics', $params);

        if ($res->getStatusCode() == 200) { // 200 OK
            $response_data = $res->getBody()->getContents();
        }
        $datas = json_decode($response_data)->data;
        $statusRevenues = $datas->statusRevenues;
        $data = [
            'all_total' => $datas->data->all_total,
            'gross_revenue' => $datas->data->gross_revenue,
            'payment' => $datas->data->payment,
            'orders' => $datas->data->orders,
            'customers' => $datas->data->customers,
            'category_service' => $datas->data->category_service,
            'category_product' => $datas->data->category_product,
            'revenue_month' => $datas->data->revenue_month,
        ];
        $products = [
            'orders' => $datas->products->orders,
            'all_total' => $datas->products->all_total,
            'gross_revenue' => $datas->products->gross_revenue,
            'the_rest' => $datas->products->the_rest,
        ];
        $services = [
            'orders' => $datas->services->orders,
            'all_total' => $datas->services->all_total,
            'gross_revenue' => $datas->services->gross_revenue,
            'the_rest' => $datas->services->the_rest,
        ];

        if ($request->ajax()) {
            return Response::json(view('statistics.ajax', compact('towers', 'data', 'services', 'products', 'statusRevenues'))->render());
        }
        return view('statistics.index', compact('towers', 'data', 'services', 'products', 'statusRevenues'));
    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }

    /**
     * Thống kê tất cả chi nhánh.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function getBranch(Request $request)
    {
        $towers = $this->tower;

        $input = $request->all();
        if (empty($request->data_time) && empty($request->end_date) && empty($request->start_date)) {
            $input['data_time'] = 'THIS_MONTH';
        }
        $params = [
            'query' => [
                'data_time' => @$input['data_time'],
                'start_date' => @$input['start_date'],
                'end_date' => @$input['end_date'],
            ]
        ];

        $response = [];
        foreach ($towers as $k => $item) {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $k . 'statistics-all', $params);

            if ($res->getStatusCode() == 200) { // 200 OK
                $response_data = $res->getBody()->getContents();
            }
            $datas = json_decode($response_data)->data;
            $response[$item] = $datas;
        }
        if ($request->ajax()) {
            return Response::json(view('statistics.ajax_branch', compact('response'))->render());
        }
        return view('statistics.index_branch', compact('response'));

    }
}
