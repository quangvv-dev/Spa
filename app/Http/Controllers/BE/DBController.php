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
        $order = Order::select('id', 'created_at')
            ->whereBetween('date', [
                '2022-06-02 00:01',
                '2022-06-05 23:01',
            ])->get();
        foreach ($order as $item) {
            $payment = PaymentHistory::where('order_id',$item->id)->first();
            if (isset($payment) && $payment){
                $item->created_at = $payment->payment_date;
                $item->save();
            }
        }

//     $role =  Role::with('users')->get();
//     foreach ($role as $item){
//         if ($item->users()){
//             $item->users()->update(['department_id'=>$item->department_id]);
//         }
//     }
//        return "OKIE";
    }
}
