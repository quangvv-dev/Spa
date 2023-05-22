<?php

namespace App\Http\Controllers\BE\Branch;

use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\CallCenter;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\Schedule;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class BranchController extends Controller
{


    public function __construct()
    {
        $branch= Branch::select('id','name')->pluck('name','id')->toArray();
        $location = Branch::$location;
        view()->share([
            'location' => $location,
            'branch'   => $branch,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $users = Branch::select('id', 'name')->when(isset($request->group_branch) && count($request->group_branch),
            function ($q) use ($request) {
                $q->whereIn('id', $request->group_branch);
            })->get()->map(function ($item) use ($request) {
            $data_new = Customer::select('id')->where('branch_id', $item->id)->whereBetween('created_at', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ]);

            $orders = Order::select('member_id', 'all_total', 'gross_revenue')->where('branch_id', $item->id)
                ->whereBetween('created_at', [
                    Functions::yearMonthDay($request->start_date) . " 00:00:00",
                    Functions::yearMonthDay($request->end_date) . " 23:59:59",
                ]);
            $orders2 = clone $orders;
            $order_new = $orders->where('is_upsale', OrderConstant::NON_UPSALE);
            $order_old = $orders2->where('is_upsale', OrderConstant::IS_UPSALE);

            $schedules = Schedule::select('id')->where('branch_id', $item->id)->whereBetween('date', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ]);
            $schedules_den = clone $schedules;
            $schedules_new = clone $schedules;

            $item->schedules_den = $schedules_den->whereIn('status',
                [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
                ->whereHas('customer', function ($qr) {
                    $qr->where('old_customer', 0);
                })->count();
            $item->schedules_new = $schedules_new->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 0);
            })->count();
            //lich hen


            $request->merge(['branch_id' => $item->id]);
            $wallet = PaymentWallet::search($request->all(), 'price'); // đã thu trong kỳ ví
            $item->payment_wallet = $wallet->sum('price');
            $detail = PaymentHistory::search($request->all(), 'price');//đã thu trong kỳ
            $detail_new = clone $detail;

            $item->detail_new = $detail_new->whereHas('order', function ($qr) {
                $qr->where('is_upsale', OrderConstant::NON_UPSALE);
            })->sum('price');
            $item->customer_new = $data_new->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->revenue_new = $order_new->sum('all_total');
            $item->revenue_old = $order_old->sum('all_total');
            $item->payment_revenue = $orders->sum('gross_revenue');
            $item->payment_new = $order_new->sum('gross_revenue');//da thu trong ky
            $item->payment_old = $order_old->sum('gross_revenue'); //da thu trong ky
            $item->revenue_total = $order_new->sum('all_total') + $order_old->sum('all_total');
            $item->all_payment = $detail->sum('price');
            $item->payment_used = $detail->where('payment_type', 3)->sum('price');//thanh toán điểm

            return $item;
        })->filter(function ($it) {
            if ($it->all_payment > 0) {
                return $it;
            }
        })->sortByDesc('all_payment');

        if ($request->ajax()) {
            return view('branch.ajax_statistics', compact('users'));
        }
        return view('branch.statistics', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function source(Request $request)
    {
        $input = $request->all();
        $users = Status::select('id', 'name')->where('type', StatusCode::SOURCE_CUSTOMER)->get();
        $users = Status::select('id', 'name')->where('type', StatusCode::SOURCE_CUSTOMER)->get()->map(function ($item) use ($request,$input) {
//        foreach ($users as $item) {
            $data_new = Customer::select('id')->whereBetween('created_at', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ])->where('source_id', $item->id)->when(!empty($input['branch_id']), function ($query) use ($input) {
                    $query->where('branch_id', $input['branch_id']);
                });

        $orders = Order::select('orders.member_id', 'orders.all_total', 'orders.gross_revenue')
            ->join('customers as c', 'c.id', '=', 'orders.member_id')
            ->where('c.source_id', $item->id)
            ->whereBetween('orders.created_at', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ])->when(!empty($input['branch_id']), function ($query) use ($input) {
                $query->where('orders.branch_id', $input['branch_id']);
            });
        $orders2 = clone $orders;
        $order_new = $orders->where('orders.is_upsale', OrderConstant::NON_UPSALE);
        $order_old = $orders2->where('orders.is_upsale', OrderConstant::IS_UPSALE);

        // Lịch hẹn
        $schedules = Schedule::join('customers as c', 'c.id', '=', 'schedules.user_id')
            ->where('c.source_id', $item->id)
            ->whereBetween('schedules.date', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ])->when(!empty($input['branch_id']), function ($query) use ($input) {
                $query->where('schedules.branch_id', $input['branch_id']);
            })->select('schedules.id');
        $schedules_den = clone $schedules;
        $schedules_new = clone $schedules;

        $item->schedules_den = $schedules_den->whereIn('status',
            [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])
            ->where('c.old_customer', OrderConstant::NON_UPSALE)->count();
        $item->schedules_new = $schedules_new->where('c.old_customer', OrderConstant::NON_UPSALE)->count();

        $wallet = PaymentWallet::select('payment_wallets.price',DB::raw('SUM(wh.order_price) as order_price'))->join('wallet_histories as wh', 'wh.id', '=',
            'payment_wallets.order_wallet_id')
            ->join('customers as c', 'wh.customer_id', '=', 'c.id')
            ->whereBetween('payment_wallets.payment_date', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ])->where('c.source_id', $item->id)
            ->when(!empty($input['branch_id']), function ($query) use ($input) {
                $query->where('payment_wallets.branch_id', $input['branch_id']);
            }); // đã thu trong kỳ ví
        $item->payment_wallet = $wallet->sum('payment_wallets.price');
        $detail = PaymentHistory::join('orders as o', 'o.id', '=', 'payment_histories.order_id')
            ->join('customers as c', 'c.id', '=', 'o.member_id')->select('payment_histories.price')
            ->whereBetween('payment_histories.payment_date', [
                Functions::yearMonthDay($request->start_date) . " 00:00:00",
                Functions::yearMonthDay($request->end_date) . " 23:59:59",
            ])->where('c.source_id', $item->id)
            ->when(!empty($input['branch_id']), function ($query) use ($input) {
                $query->where('payment_histories.branch_id', $input['branch_id']);
            })->select('payment_histories.price');//đã thu trong kỳ
        $detail_new = clone $detail;
        $item->detail_new = $detail_new->where('o.is_upsale', OrderConstant::NON_UPSALE)->sum('price');
        $item->customer_new = $data_new->count();
        $item->order_new = $order_new->count();
        $item->order_old = $order_old->count();
        $item->revenue_new = $order_new->sum('orders.all_total');
        $item->revenue_old = $order_old->sum('orders.all_total');
        $item->payment_revenue = $orders->sum('orders.gross_revenue');
        $item->payment_new = $order_new->sum('orders.gross_revenue');//da thu trong ky
        $item->payment_old = $order_old->sum('orders.gross_revenue'); //da thu trong ky
        $item->revenue_total = $order_new->sum('orders.all_total') + $order_old->sum('orders.all_total') + $wallet->sum('order_price');
        $item->all_payment = $detail->sum('payment_histories.price');
        $item->payment_used = $detail->where('payment_histories.payment_type', 3)->sum('payment_histories.price');//thanh toán điểm
            return $item;
        })->filter(function ($it) {
            if ($it->all_payment > 0) {
                return $it;
            }
        })->sortByDesc('all_payment');
//    }
        if ($request->ajax()) {
            return view('branch.source.ajax', compact('users'));
        }
        return view('branch.source.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(CallCenter $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getStreamLink(CallCenter $id)
    {
        $doc = $id;
        return view('call_center.stream', compact('doc'));
    }
}
