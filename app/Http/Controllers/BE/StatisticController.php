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
        $title = 'Nhân viên';

        $statusRevenues = Status::getRevenueSource();
        $statusRevenueByRelations = Status::getRevenueSourceByRelation();

        $categoryRevenues = Category::getRevenue();
        $customerRevenueByGenders = Customer::getRevenueByGender();
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
        $orders = OrderDetail::orderBy('id', 'desc');
        $price_customer = Customer::where('status_id', 13)->get();
        $commision = Commission::orderBy('id', 'desc');

        if ($request->user_id) {

        } else {
            $customer = $customer->where('telesales_id', Auth::user()->id)->where('status_id',
                StatusCode::NEW)->with('source_customer')->get();
            $books = $books->where('creator_id', Auth::user()->id)->get();
            $receive = $receive->where('creator_id', Auth::user()->id)->get();
            $comment = $comment->where('user_id', Auth::user()->id)->get();
            $orders = $orders->where('user_id', Auth::user()->id)->get();
            $commision = $commision->where('customer_id', 'like', '%' . Auth::user()->id . '%')->get();
            if (count($commision)) {
                foreach ($commision as $item) {
                    if ($item->customer_id) {
                        foreach (json_decode($item->customer_id) as $key => $value1) {
                            if ($value1 == Auth::user()->id) {
                                $rose_price = json_decode($item->rose_price);
                                $price_commision[] = $rose_price[$key];
                            }
                        }
                    }
                }
                $price_commision = array_sum($price_commision);
            }
        }
        $customer = count($customer);
        $books = count($books);
        $receive = count($receive);
        $comment = count($comment);
        $orders = count($orders);
        $price_customer = count($price_customer);
        $commision = $price_commision;

        if ($request->ajax()) {
            return Response::json(view('statistics.ajax_home',
                compact('customer', 'books', 'receive', 'comment', 'orders', 'price_customer', 'commision',
                    'title', 'statusRevenues', 'statusRevenueByRelations', 'categoryRevenues', 'customerRevenueByGenders'))->render());
        }
        return view('statistics.index',
            compact('customer', 'books', 'receive', 'comment', 'orders', 'price_customer', 'commision', 'title', 'statusRevenues', 'statusRevenueByRelations', 'categoryRevenues', 'customerRevenueByGenders'));
    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }
}
