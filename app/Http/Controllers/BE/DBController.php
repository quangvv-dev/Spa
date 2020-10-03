<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Commission;

class DBController extends Controller
{
    public function index()
    {
        Customer::whereNotIn('telesales_id', [68, 98])->update(['telesales_id' => 91]);
        return 1;
    }
}
