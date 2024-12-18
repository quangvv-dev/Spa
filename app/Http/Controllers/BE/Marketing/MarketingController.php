<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Resources\MarketingResource;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\PriceMarketing;
use App\Models\Schedule;
use App\Models\Source;
use App\Models\Team;
use App\Models\ThuChi;
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
        $this->middleware('permission:carepage.index', ['only' => ['index']]);
        $branchs = Branch::search()->pluck('name', 'id');
        $location = Branch::getLocation();
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
        $teams = Team::select('id','name')->where('department_id', DepartmentConstant::MARKETING)->pluck('name','id')->toArray();

        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $members = Functions::members($input);

        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        if (Auth::user()->department_id == DepartmentConstant::MARKETING) {
            $group_branch = Branch::where('location_id', @Auth::user()->branch->location_id)->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $marketing = User::where('department_id', DepartmentConstant::MARKETING)->where('active',StatusCode::ON)
            ->when(!empty($members), function ($q) use ($members) {
                $q->whereIn('id', $members);
            })->select('id', 'full_name', 'avatar')->get()->map(function ($item) use ($input) {
                $input['marketing'] = $item->id;
                $customer = Customer::searchApi($input)->select('id');
                $item->contact = $customer->count();
                $orders = Order::searchAll($input)->select('id', 'gross_revenue', 'all_total');
                $item->orders = $orders->count();
                $item->all_total = $orders->sum('all_total');
                $payment = PaymentHistory::search($input, 'price,order_id')->whereHas('order', function ($item) {
                    $item->where('is_upsale', OrderConstant::NON_UPSALE);
                });
                $item->gross_revenue = $payment->sum('price');
                $input['marketing'] = $item->id;
                $input['is_upsale'] = OrderConstant::NON_UPSALE;
                $input['date_customers'] = OrderConstant::NON_UPSALE;
                $item->schedules = Schedule::search($input)->count();
                return $item;
            })->sortByDesc('gross_revenue');
        $marketing =  MarketingResource::collection($marketing);
        if ($request->ajax()) {
            return view('marketing.leader.ajax', compact('marketing'));
        }

        return view('marketing.leader.index', compact('marketing', 'teams'));
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
     * @param \Illuminate\Http\Request $request
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
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $users = Auth::user();
        if ($users->department_id == DepartmentConstant::WAITER) {
            $request->merge(['branch_id' => $users->branch_id]);
        }
        $input = $request->all();
        $input['searchAccept'] = UserConstant::ACTIVE;
        $source = Source::with('user')->get()->map(function ($item) use ($input) {
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
                ->select('id', 'gross_revenue', 'all_total');
            unset($input['marketing']);
            $input['source_id'] = $item->id;
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
     * @param int $id
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
                    'comment' => str_replace(",", "", $request->comment[$key]),
                    'message' => str_replace(",", "", $request->message[$key]),
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
                    'comment' => str_replace(",", "", $request->comment[$key]),
                    'message' => str_replace(",", "", $request->message[$key]),
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
        $teams = Team::select('id','name')->where('department_id', DepartmentConstant::MARKETING)->pluck('name','id')->toArray();

        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $members = Functions::members($request->all());

        $input = $request->all();
        $marketing = User::where('department_id', DepartmentConstant::MARKETING)->where('active',StatusCode::ON)
            ->when(!empty($members), function ($q) use ($members) {
                $q->whereIn('id', $members);
            })->select('id', 'full_name', 'avatar')->get()->map(function ($item) use ($input) {
            $input['marketing'] = $item->id;
            $input['is_upsale'] = OrderConstant::NON_UPSALE;
            $payment = PaymentHistory::search($input, 'price,order_id')->whereHas('order', function ($item) {
                $item->where('is_upsale', OrderConstant::NON_UPSALE);
            });
            $item->gross_revenue = $payment->sum('price');
            return $item;
        })->sortByDesc('gross_revenue')->toArray();

        $my_key = array_keys(array_column((array)$marketing, 'id'), Auth::user()->id);

        if ($request->ajax()) {
            return view('marketing.ranking.ajax', compact('marketing', 'my_key'));
        }
        return view('marketing.ranking.index', compact('marketing', 'my_key', 'teams'));
    }
}
