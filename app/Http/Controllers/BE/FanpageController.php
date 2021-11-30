<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Category;
use App\Models\Status;
use App\Services\CustomerService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FanpageController extends Controller
{

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray();//mối quan hệ
        $group = Category::pluck('name', 'id')->toArray();//nhóm KH
        $source = Status::where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();// nguồn KH
        $marketingUsers = User::where('role', UserConstant::MARKETING)->pluck('full_name', 'id')->toArray();
        $telesales = User::where('role', UserConstant::TELESALES)->pluck('full_name', 'id')->toArray();
        view()->share([
            'status'         => $status,
            'group'          => $group,
            'source'         => $source,
            'telesales'      => $telesales,
            'marketingUsers' => $marketingUsers,
        ]);
    }

    public function index()
    {
        $fanpages = [];
        return view('marketing.fanpage.index',compact('fanpages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('group_id');
        $input['mkt_id'] = $request->mkt_id;

        $customer = $this->customerService->create($input);
        $category = Category::find($request->group_id);
        $customer->categories()->attach($category);

        return back();
    }
}
