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
        for ($i = 1; $i < 17; $i++) {
            $status = Functions::getStatusWithCode('khach_hang_vip');
            $order = Order::select('member_id','gross_revenue', \DB::raw('SUM(gross_revenue) AS total'))->where('branch_id', $i)
                ->groupBy('member_id')->havingRaw('total > 20000000')->pluck('member_id');
            Customer::whereIn('id', $order)->update(['status_id' => $status]);
        }
        return "OKIE";
    }
}
