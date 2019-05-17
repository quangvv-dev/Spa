<?php

namespace App\Http\Controllers\BE;

use App\Components\Filesystem\Filesystem;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Category;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $users = User::with('status', 'marketing');
        $status = Status::get();
        $title = 'Quản lý khách hàng';
        $search = $request->search;
        $searchStatus = $request->status;

        if (Auth::user()->role == UserConstant::MARKETING || Auth::user()->role == UserConstant::TELESALES) {
            $users = $users->where('role', UserConstant::CUSTOMER)->where('mkt_id', Auth::user()->id);
            $title = "Tạo khách hàng mới";
        }
        if ($search) {
            $users = $users->where(function ($query) use ($search) {
                $query->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($searchStatus) {
            $users->whereHas('status', function ($query) use ($searchStatus) {
                $query->where('status.name', $searchStatus);
            });
        }

        $users = $users->where('role', UserConstant::CUSTOMER)
            ->paginate(10);

        if ($request->ajax()) {
            return Response::json(view('customers.ajax', compact('users','status', 'title'))->render());
        }

        return view('customers.index', compact('users', 'status', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
