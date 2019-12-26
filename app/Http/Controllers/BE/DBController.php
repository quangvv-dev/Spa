<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class DBController extends Controller
{
    public function index()
    {
        $check = Customer::whereNull('fb_name')->get();
        foreach ($check as $item) {
            $item->fb_name = $item->full_name;
            $item->save();
        }
        return 1;
    }
}
