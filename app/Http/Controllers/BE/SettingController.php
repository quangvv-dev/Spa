<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\StatusCode;

class SettingController extends Controller
{
    public function store(Request $request)
    {
        setting([
            'view_customer_sale' => $request->value,
        ])->save();
        return setting('view_customer_sale');
    }
}
