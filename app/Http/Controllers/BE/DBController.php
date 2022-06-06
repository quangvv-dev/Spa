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
        $order = Order::whereBetween('created_at', [
                '2022-05-01 00:01',
                '2022-06-06 23:59',
            ])->where('telesale_id',0)->with('customer')->get();

        foreach ($order as $item) {
            if ($item->customer){
                $item->carepage_id = !empty($item->customer->carepage_id)?$item->customer->carepage_id:0;
                $item->save();
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
