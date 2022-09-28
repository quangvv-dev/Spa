<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Helpers\Functions;
use App\Models\PaymentHistory;
use App\Models\Role;
use Illuminate\Http\Request;

class DBController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $payment = PaymentHistory::select('id')->whereBetween('payment_date', [$start_date, $end_date])->pluck('id')->toArray();
        $order = Order::whereIn('id', $payment)->with('customer')->get();

        foreach ($order->chunk(100) as $item) {
            foreach ($item as $data){
                if (isset($data->customer)) {
                    $data->source_id = !empty($data->customer->source_id) ? $data->customer->source_id : 0;
                    $data->save();
                }
            }

        }
        return "da xong";

//     $role =  Role::with('users')->get();
//     foreach ($role as $item){
//         if ($item->users()){
//             $item->users()->update(['department_id'=>$item->department_id]);
//         }
//     }
//        return "OKIE";
    }
}
