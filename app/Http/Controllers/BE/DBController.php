<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Commission;

class DBController extends Controller
{
    public function index()
    {
        $input['data_time'] = 'THIS_MONTH';
        $query = Order::returnRawData($input)->get();
        foreach ($query as $item) {
            Commission::where('order_id', $item->id)->update(['created_at' => $item->created_at]);
        }
        return 1;
    }
}
