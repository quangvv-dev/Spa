<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Helpers\Functions;
use Illuminate\Http\Request;

class DBController extends Controller
{
    public function index(Request $request)
    {
        $status = Functions::getStatusWithCode('nguoi_mua_hang');
        $order = Order::select('member_id', \DB::raw('COUNT(member_id) AS total'))->where('branch_id', $request->branch)
            ->groupBy('member_id')->havingRaw('total = 1')->pluck('member_id');
        Customer::whereIn('id', $order)->update(['status_id' => $status]);
        return "OKIE";
    }
}
