<?php

namespace App\Http\Controllers\BE\Cskh;

use App\Constants\DepartmentConstant;
use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CallCenter;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\User;
use Illuminate\Http\Request;

class CskhController extends Controller
{

    public function __construct()
    {
        $location = Branch::getLocation();
        view()->share([
            'location' => $location,
        ]);
    }

    public function ranking(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = count($group_branch) ? $group_branch : [0];
        }
        $users = User::select('id','full_name')->where('department_id', DepartmentConstant::CSKH)->get()->map(function ($item) use ($input) {
            $input['cskh_id'] = $item->id;
            $input['search_date'] = 'time_move_cskh';
            $customer = Customer::search($input);
            if ($item->caller_number) {
                $input_call = [
                    'start_date' => $input['start_date'],
                    'end_date' => $input['end_date'],
                    'caller_number' => $item->caller_number,
                    'call_status' => 'ANSWERED',
                ];
            }
            $item->phone = $customer->count();
            $item->call = isset($input_call) ? CallCenter::search($input_call, 'id')->count() : 0;

            $orders = Order::search($input);
            $item->orders = $orders->count();
            $item->all_total = $orders->sum('all_total');
            $item->gross_revenue = $orders->sum('gross_revenue');

            $item->payment = PaymentHistory::search($input)->sum('price');
            return $item;

        });
        if ($request->ajax()) {
            return view('cskh.ajax',compact('users'));
        }
        return view('cskh.index',compact('users'));
    }
}
