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

class CarepageController extends Controller
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

        $marketing = User::where('department_id', DepartmentConstant::CARE_PAGE)->select('id', 'full_name')->get()->map(function ($item) use ($input) {
            $input['carepage_id'] = $item->id;
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
            $orders = Order::searchAll($input)->select('id', 'order_id', 'gross_revenue', 'all_total');
            $payment = PaymentHistory::search($input, 'price','order_id')->get();
            $item->orders = $orders->count();
            $item->all_total = $orders->sum('all_total');
            $item->gross_revenue = $orders->sum('gross_revenue');
            $item->payment = $payment->sum('price');
            return $item;
        })->sortByDesc('payment')->filter(function ($q){
            if ((int)$q->payment >0 ){
                return $q;
            }
        });
        if ($request->ajax()) {
            return view('marketing.carepage.ajax', compact('marketing'));
        }

        return view('marketing.carepage.index', compact('marketing'));
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
        $marketing = User::where('department_id', DepartmentConstant::CARE_PAGE)->select('id', 'full_name', 'avatar')->get()->map(function ($item) use ($input) {
            $input['carepage_id'] = $item->id;
            $data = Order::searchAll($input)->select('gross_revenue');
            $item->gross_revenue = $data->sum('gross_revenue');
            return $item;
        })->sortByDesc('gross_revenue')->toArray();

        $my_key = array_keys(array_column((array)$marketing, 'id'), Auth::user()->id);

        if ($request->ajax()) {
            return view('marketing.rankingCarepage.ajax', compact('marketing', 'my_key'));
        }
        return view('marketing.rankingCarepage.index', compact('marketing', 'my_key'));
    }
}
