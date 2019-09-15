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
        $customers = User::where('role', '<>', UserConstant::MARKETING)->pluck('full_name', 'id');
        $doc = Commission::where('order_id', $id)->first();
        $commissions = Commission::where('order_id', $id)->get();
        if (isset($doc) && $doc) {
            return view('commisstion.index', compact('title', 'customers', 'doc', 'commissions'));
        } else {
            return view('commisstion.index', compact('title', 'customers'));
        }
    }

    public function store(Request $request, $id)
    {
        $input = $request->except('_token');
        $input['earn'] = str_replace(',', '', $request->earn);
        $input['order_id'] = $id;

        Commission::create($input);
        return redirect(url('order/' . $id . '/show'));
    }

    public function update(Request $request, Commission $commission)
    {
        $commission1 = Commission::where('id', $request->id)->first();
        $input = $request->except('_token', 'order_id');
        $input['earn'] = str_replace(',', '', $request->earn);
        $input['order_id'] = $commission1->order_id;

        $commission->fill($input);
        $commission->save();
        return redirect('order/' . $commission1->order_id . '/show');
    }
}
