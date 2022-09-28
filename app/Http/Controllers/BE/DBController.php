<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Helpers\Functions;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\Role;
use App\Models\WalletHistory;
use Illuminate\Http\Request;

class DBController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->type ==1){
            $payment_wallet = PaymentWallet::select('order_wallet_id')->whereBetween('payment_date', [$start_date, $end_date])->pluck('order_wallet_id')->toArray();
            $wallet = WalletHistory::whereIn('id', $payment_wallet)->with('customer')->has('customer')->get();
            foreach ($wallet as $data){
                if (isset($data->customer)) {
                    $data->source_id = !empty($data->customer->source_id) ? $data->customer->source_id : 0;
                    $data->save();
                }
            }
        }else{
            $payment = PaymentHistory::select('order_id')->whereBetween('payment_date', [$start_date, $end_date])->pluck('order_id')->toArray();
            $order = Order::whereIn('id', $payment)->with('customer')->has('customer')->get();

            foreach ($order->chunk(100) as $item) {
                foreach ($item as $data){
                    if (isset($data->customer)) {
                        $data->source_id = !empty($data->customer->source_id) ? $data->customer->source_id : 0;
                        $data->save();
                    }
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
