<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DBController extends Controller
{
    public function index()
    {
        $orders = Order::select('member_id')->whereBetween('created_at', ["2022-01-01 00:00:00", "2022-01-30 23:59:59"])
            ->whereHas('customer', function ($qr) {
                $qr->where('old_customer', 1);
            })->groupBy('member_id')
            ->pluck('member_id')->toArray();

        return $orders;
    }
}
