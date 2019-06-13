<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Commission;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommissionController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index($id)
    {
        $title = 'Hoa hồng upsale';
        $customers = User::where('role', '<>', UserConstant::CUSTOMER)->where('role', '<>',
            UserConstant::ADMIN)->pluck('full_name', 'id');
        $doc = Commission::where('order_id', $id)->first();
        if (isset($doc) && $doc) {
            return view('commisstion.index', compact('title', 'customers', 'doc'));
        } else {
            return view('commisstion.index', compact('title', 'customers'));
        }
    }

    public function store(Request $request, $id)
    {
        $price = [];
        if (isset($request->rose_price) && $request->rose_price) {
            foreach ($request->rose_price as $item) {
                $price[] = str_replace(',', '', $item);
            }
        }
        $request->merge([
            'customer_id' => json_encode($request->customer_id),
            'rose_price'  => json_encode($price),
            'order_id'    => $id,
        ]);
        Commission::create($request->except('_token'));
        return redirect(url('commission/' . $id));
    }

    public function update(Request $request, Commission $id)
    {
        $price = [];
        if (isset($request->rose_price) && $request->rose_price) {
            foreach ($request->rose_price as $item) {
                $price[] = str_replace(',', '', $item);
            }
        }
        $request->merge([
            'customer_id' => json_encode($request->customer_id),
            'rose_price'  => json_encode($price),
            'order_id'    => $id,
        ]);
        $id->update($request->except('_token','order_id'));
        return back();
    }
}
