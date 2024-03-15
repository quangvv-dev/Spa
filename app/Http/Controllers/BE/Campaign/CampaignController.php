<?php

namespace App\Http\Controllers\BE\Campaign;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{
    public function __construct()
    {
        view()->share([
            'branchs' => Branch::pluck('name', 'id')->toArray(),
            'cskh' => User::where('department_id', DepartmentConstant::CSKH)->pluck('full_name', 'id')->toArray(),
            'sale' => User::where('department_id', DepartmentConstant::TELESALES)->pluck('full_name', 'id')->toArray(),
            'status' => Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray()
        ]);
    }

    public function checkCampaign(Request $request)
    {
       return $this->loadCustomer($request)->count();
    }

    public function loadCustomer($request){
        return Order::select('c.id')->join('customers as c', 'c.id', '=', 'orders.member_id')
            ->whereBetween('orders.created_at', [$request->from_order . " 00:00:00", $request->to_order . " 23:59:59"])
            ->whereIn('c.status_id',$request->status)->whereIn('orders.branch_id',$request->branch)->groupBy('orders.member_id')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('campaigns._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
