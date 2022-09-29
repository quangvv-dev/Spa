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
use App\Models\Status;
use App\Models\WalletHistory;
use Illuminate\Http\Request;

class DBController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
//        $input = $request->all();
//
//        $payment_wallet = PaymentWallet::search($input, 'price')->sum('price');
//
//        $payment_All = PaymentHistory::search($input, 'price');
//        $price = $payment_All->sum('price');
//        $score = $payment_All->where('payment_type', 3)->sum('price');
//
//        $data = Status::where('type', StatusCode::SOURCE_CUSTOMER)->select('id', 'name')->get()->map(function ($item) use ($input) {
//            $payment_wallet = PaymentWallet::search($input, 'price')->whereHas('order_wallet', function ($it) use ($item) {
//                $it->where('source_id', $item->id);
//            })->sum('price');
//            $payment_All = PaymentHistory::search($input, 'price')->whereHas('order', function ($it) use ($item) {
//                $it->where('source_id', $item->id);
//            });
//            $price = $payment_All->sum('price');
//            $score = $payment_All->where('payment_type', 3)->sum('price');
//
//            $item->total = $price + $payment_wallet - $score;
//            return $item;
//        })->filter(function ($fl) {
//            if ($fl->total > 0) {
//                return $fl;
//            }
//        })->sortByDesc('total');
//        return [
//            'record' => $data,
//            'all_total' => $data->sum('total'),
//            'all_total_thuc' => $price + $payment_wallet - $score,
//        ];


        if ($request->type ==1){
            $wallet = WalletHistory::with('customer')->has('customer')->get();
            foreach ($wallet as $data){
                if (isset($data->customer)) {
                    $data->source_id = !empty($data->customer->source_id) ? $data->customer->source_id : 0;
                    $data->save();
                }
            }
        }else{
//            $payment = PaymentHistory::select('order_id')->whereBetween('payment_date', [$start_date, $end_date])->pluck('order_id')->toArray();
            $payment = PaymentHistory::select('order_id')->pluck('order_id')->toArray();
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
