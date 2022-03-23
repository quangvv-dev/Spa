<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Models\Source;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MarketingController extends Controller
{

    public function __construct()
    {
        $branchs = Branch::search()->pluck('name', 'id');
        $location = Branch::$location;
        view()->share([
            'branchs' => $branchs,
            'location' => $location,
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
        $input = $request->all();
//        dd($input);
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }

        $marketing = User::where('department_id', 3)->select('id', 'full_name')->get()->map(function ($item) use ($input) {
            $input['marketing'] = $item->id;
            $customer = Customer::search($input)->select('id');
            $item->contact = $customer->count();
            $input['group_user'] = $customer->pluck('id')->toArray();
            $schedules = Schedule::search($input)->select('id');
            $item->schedules = $schedules->count();
            $item->schedules_den = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
            $orders = Order::searchAll($input)->select('id', 'gross_revenue');
            $payment = PaymentHistory::search($input, 'price')->whereIn('order_id', $orders->pluck('id')->toArray());
            $item->orders = $orders->count();
            $item->all_total = $orders->sum('all_total');
            $item->gross_revenue = $orders->sum('gross_revenue');
            $item->payment = $payment->sum('price');
            return $item;
        })->sortByDesc('payment');
        if ($request->ajax()) {
            return view('marketing.leader.ajax', compact('marketing'));
        }

        return view('marketing.leader.index', compact('marketing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDate($request);
        }
        $input = $request->all();
        $input['searchAccept'] = UserConstant::ACTIVE;

        $marketing = User::where('department_id', 3)->select('id', 'full_name')->get()->map(function ($item) use ($input) {
            $input['marketing'] = $item->id;
            $customer = Customer::search($input)->select('id');
            $item->contact = $customer->count();
            $input['group_user'] = $customer->pluck('id')->toArray();
            $schedules = Schedule::search($input)->select('id');
            $item->schedules = $schedules->count();
            $item->schedules_den = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
            $orders = Order::searchAll($input)->select('gross_revenue');

            $item->all_total = $orders->sum('all_total');
            $item->gross_revenue = $orders->sum('gross_revenue');

        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Bảng xếp hạng MKT
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ranking(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }

        $input = $request->all();
        $marketing = User::where('department_id', 3)->select('id', 'full_name', 'avatar')->get()->map(function ($item) use ($input) {
            $input['marketing'] = $item->id;
            $data = Order::searchAll($input)->select('gross_revenue');
            $item->gross_revenue = $data->sum('gross_revenue');
            return $item;
        })->sortByDesc('gross_revenue')->toArray();

        $my_key = array_keys(array_column((array)$marketing, 'id'), Auth::user()->id);

        if ($request->ajax()) {
            return view('marketing.ranking.ajax', compact('marketing', 'my_key'));
        }
        return view('marketing.ranking.index', compact('marketing', 'my_key'));
    }
}
