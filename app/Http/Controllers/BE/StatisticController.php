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

    public function index(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->has('user_id') ? $request->user_id : Auth::user()->id;
        $title = 'Nhân viên';

        if ($request->has('data_time') == null) {
            $input['data_time'] = 'THIS_MONTH';
        }

        $order_arr = [];
        $commissions = Commission::where('user_id', $input['user_id'])->get();
        foreach ($commissions as $commiss) {
            $order_arr[] = $commiss->order_id;
        }

        $input['order_id'] = $order_arr;

        $orders = Order::whereIn('id', $order_arr);
        $orders = $orders->when(isset($input['data_time']), function ($query) use ($input) {
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
            })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
                $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date'])." 00:00:00", Functions::yearMonthDay($input['end_date'])." 23:59:59"]);
            })
            ->get();

        $orders = $orders->map(function ($order) use ($request, $input) {
            $check = Commission::where('order_id', $order->id)->where('user_id', $input['user_id'])->first();
            if (isset($check) && $check) {
                $order->rose_price = !empty($check->earn) ? $check->earn : 0;
            }
            return $order;
        });

        $statusRevenues = Status::getRevenueSource($input);
        $statusRevenueByRelations = Status::getRevenueSourceByRelation($input);

        $categoryRevenues = Category::getRevenue($input);
        $customerRevenueByGenders = Customer::getRevenueByGender($input);
        $customer = Customer::count($input);
        $groupComments = GroupComment::getAll($input);

        $schedule = Schedule::orderBy('id', 'DESC');
        $schedule->when(isset($input['data_time']), function ($query) use ($input) {
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
        })
        ->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [Functions::yearMonthDay($input['start_date'])." 00:00:00", Functions::yearMonthDay($input['end_date'])." 23:59:59"]);
        });
        $books = $schedule->where('status', StatusCode::BOOK)->where('creator_id', $input['user_id'])->get();
        $receive = $schedule->where('status', StatusCode::RECEIVE)->where('creator_id', $input['user_id'])->get();
        $comment = $schedule->where('user_id', $input['user_id'])
            ->where('status', '<>', StatusCode::BOOK)
            ->where('status', '<>', StatusCode::RECEIVE)->get();

        if ($request->ajax()) {
            return Response::json(view('statistics.ajax_home',
                compact('customer',
                    'books',
                    'receive',
                    'comment',
                    'commissions',
                    'title',
                    'statusRevenues',
                    'statusRevenueByRelations',
                    'categoryRevenues',
                    'customerRevenueByGenders',
                    'orders',
                    'groupComments'
                ))->render());
        }
        return view('statistics.index',
            compact(
                'customer',
                'books',
                'receive',
                'comment',
                'commissions',
                'title',
                'orders',
                'statusRevenues',
                'statusRevenueByRelations',
                'categoryRevenues',
                'customerRevenueByGenders',
                'groupComments'
            ));
    }

    public function show($id)
    {
        $title = 'Chi tiết thống kê';
        $total = $this->customer->getStatisticsUsers()->get()->sum('count');
        $detail = $this->customer->getStatisticsUsers()->where('mkt_id', $id)->first();

        return view('statistics.detail', compact('detail', 'title', 'total'));
    }
}
