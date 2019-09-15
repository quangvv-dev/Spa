<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Category;
use App\Models\Commission;
use App\Models\Customer;
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

    public function index(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user_id?: Auth::user()->id;
        $title = 'Nhân viên';

        $statusRevenues = Status::getRevenueSource($input);
        $statusRevenueByRelations = Status::getRevenueSourceByRelation($input);

        $categoryRevenues = Category::getRevenue($input);
        $customerRevenueByGenders = Customer::getRevenueByGender($input);
        $price_commision = [];
        $customer = Customer::orderBy('id', 'desc');
        $books = Schedule::where('status', StatusCode::BOOK);
        $books->when(isset($input['data_time']), function ($query) use ($input) {
            $query->when($input['data_time'] == 'TODAY' ||
                $input['data_time'] == 'YESTERDAY', function ($q) use ($input) {
                $q->whereDate('created_at', getTime(($input['data_time'])));
            })
                ->when($input['data_time'] == 'THIS_WEEK' ||
                    $input['data_time'] == 'LAST_WEEK' ||
                    $input['data_time'] == 'LAST_WEEK' ||
                    $input['data_time'] == 'THIS_MONTH' ||
                    $input['data_time'] == 'LAST_MONTH', function ($q) use ($input) {
                    $q->whereBetween('created_at', getTime(($input['data_time'])));
                });
        });
        $receive = Schedule::where('status', StatusCode::RECEIVE);
        $comment = Schedule::orderBy('id', 'desc');

        $price_customer = Customer::where('status_id', 13)->get();
        $commision = Commission::orderBy('id', 'desc');

        $customer = $customer->where('telesales_id', $input['user_id'])->where('status_id',
            StatusCode::NEW)->with('source_customer')->get();
        $books = $books->where('creator_id', $input['user_id'])->get();
        $receive = $receive->where('creator_id', $input['user_id'])->get();
        $comment = $comment->where('user_id', $input['user_id'])->get();

        $orders = Order::whereHas('customer', function ($query) use ($input) {
            $query->where('mkt_id', $input['user_id']);
        });

        $countOrders = $orders->count();

        $orders = $orders->get();
        $dataOrder = [];

        $commision = $commision->where('customer_id', 'like', '%' . $input['user_id'] . '%')->get();

        if (count($commision)) {
            foreach ($commision as $item) {
                if ($item->customer_id) {
                    foreach (json_decode($item->customer_id) as $key => $value1) {
                        if ($value1 == $input['user_id']) {
                            $rose_price = json_decode($item->rose_price);
                            $price_commision[] = $rose_price[$key];
                        }
                    }
                }
            }
            $price_commision = array_sum($price_commision);
        }

        foreach ($orders as $order) {
            foreach ($commision as $item) {
                if ($item->customer_id && $order->customer->mkt_id) {
                    foreach (json_decode($item->customer_id) as $key => $value) {
                        if ($order->id == $item->order_id) {
                            $rosePrice = array_sum(json_decode($item->rose_price));
                            $order->rose_price = $rosePrice[$key];
                        }
                    }
                }
            }
        }

        $price_customer = count($price_customer);
        $commision = $price_commision;

        if ($request->ajax()) {
            return Response::json(view('statistics.ajax_home',
                compact('customer', 'books', 'receive', 'comment', 'countOrders', 'price_customer', 'commision',
                    'title', 'statusRevenues', 'statusRevenueByRelations', 'categoryRevenues', 'customerRevenueByGenders', 'orders'))->render());
        }
        return view('statistics.index',
            compact('customer', 'books', 'receive', 'comment', 'countOrders', 'price_customer', 'commision', 'title','orders', 'statusRevenues', 'statusRevenueByRelations', 'categoryRevenues', 'customerRevenueByGenders'));
    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }
}
