<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\PriceMarketing;
use App\Models\Schedule;
use App\Models\Source;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use function JmesPath\search;

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
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
//        $input['marketing'] = 0;

        $marketing = User::where('department_id', DepartmentConstant::MARKETING)->select('id', 'full_name')->get()->map(function ($item) use ($input) {
            $input['marketing'] = $item->id;
            $customer = Customer::search($input)->select('id');
            $item->contact = $customer->count();
            $group_user = $customer->pluck('id')->toArray();
            $input['group_user'] = $group_user;

            if (count($group_user)) {
                $schedules = Schedule::search($input)->select('id');
                $item->schedules = $schedules->count();
                $item->schedules_den = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
            } else {
                $item->schedules = 0;
                $item->schedules_den = 0;
            }
            $orders = Order::searchAll($input)->select('id', 'gross_revenue','all_total');
            $payment = PaymentHistory::search($input, 'price')->whereIn('order_id', $orders->pluck('id')->toArray());

            unset($input['marketing']);
            $input['user_id'] = $item->id;
            $price = PriceMarketing::search($input)->select('budget', \DB::raw('sum(budget) as total_budget'))->first();
            $item->budget = $price->total_budget; //ngân sách
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
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $input['searchAccept'] = UserConstant::ACTIVE;
        $source = Source::search($input)->with('user')->get()->map(function ($item) use ($input) {
            $input['source_fb'] = $item->id;
            $customer = Customer::search($input)->select('id');
            $input['group_user'] = $customer->pluck('id')->toArray();
            if (count($input['group_user'])) {
                $schedules = Schedule::search($input)->select('id');
                $item->schedules = $schedules->count();
                $item->schedules_den = $schedules->whereIn('status', [ScheduleConstant::DEN_MUA, ScheduleConstant::CHUA_MUA])->count();
            } else {
                $item->schedules = 0;
                $item->schedules_den = 0;
            }
            $input['source_id'] = $item->id;

            $orders = Order::searchAll($input)->where('is_upsale', OrderConstant::NON_UPSALE)
                ->select('id', 'gross_revenue','all_total');
            unset($input['marketing']);
            $input['user_id'] = $item->id;
            $price = PriceMarketing::search($input)->select('budget', \DB::raw('sum(budget) as total_budget'))->first();
            $item->budget = $price->total_budget; //ngân sách
            $item->customers = $customer->count();
            $item->orders = $orders->count();
            $item->all_total = $orders->sum('all_total');
            $item->gross_revenue = $orders->sum('gross_revenue');
            return $item;
        })->sortByDesc('payment');
        if ($request->ajax()) {
            return view('marketing.dashbroad.ajax', compact('source'));
        }

        return view('marketing.dashbroad.index', compact('source'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function addLinePriceMarketing(Request $request)
    {
        $user = Auth::user();
        if ($request->id && count($request->id)) {

            foreach ($request->id as $key => $item) {
                PriceMarketing::find($item)->update([
                    'source_id' => $request->source_id,
                    'budget' => str_replace(",", "", $request->budget[$key]),
                    'date' => Carbon::createFromFormat('d/m/Y', $request->date[$key])->format('Y-m-d'),
                    'user_id' => $user->id,
                    'branch_id' => $request->branch_id,
                ]);
            }
        } else {
            foreach ($request->budget as $key => $item) {
                PriceMarketing::create([
                    'source_id' => $request->source_id,
                    'user_id' => $user->id,
                    'branch_id' => $request->branch_id,
                    'budget' => str_replace(",", "", $item),
                    'date' => Functions::createYearMonthDay($request->date[$key]),
                ]);
            }
        }
        return back();
    }

    public function searchPriceMarketing(Request $request)
    {
        $input = $request->all();
        $price = PriceMarketing::search($input)->with('user')->get();
        return $price;
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
    public function destroy(Request $request, $id)
    {
        PriceMarketing::find($id)->delete();
        $request->session()->flash('error', 'Xóa thành công bản ghi ngân sách!');
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
