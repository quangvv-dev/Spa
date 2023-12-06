<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Models\Customer;
use App\Models\Status;
use App\Services\CustomerService;
use App\Services\GroupCommentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupCommentController extends Controller
{
    protected $groupCommentService;
    protected $customerService;

    /**
     * GroupCommentController constructor.
     * @param GroupCommentService $groupCommentService
     * @param CustomerService $customerService
     */
    public function __construct(GroupCommentService $groupCommentService, CustomerService $customerService)
    {
        $this->groupCommentService = $groupCommentService;
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $customer = Customer::find($id);
        $groupComments = GroupComment::with('user', 'customer')
            ->where('customer_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'customer' => $customer,
            'group_comments' => $groupComments
        ]);
    }

    /**
     * Trao đổi nhanh.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2(Request $request, $id)
    {
        $customer = Customer::with('telesale', 'source_customer', 'orders', 'cskh', 'categories')->find($id);
        $orderRevenue = number_format($customer->orders->sum('gross_revenue'));
        $groupComments = DB::table('group_comments')->join('users as u', 'u.id', '=', 'group_comments.user_id')
            ->where('group_comments.customer_id', $id)
            ->select('u.full_name','group_comments.id','group_comments.created_at','group_comments.messages','group_comments.image')
            ->orderBy('id', 'desc')
            ->get();

        $lastContact = $groupComments->isEmpty() ? Carbon::parse($customer->created_at)->format('d-m-Y') : Carbon::parse($groupComments[0]->created_at)->format('d-m-Y');
        $status = Status::select('id', 'name')->where('type', StatusCode::RELATIONSHIP)->get();

        return response()->json([
            'customer' => $customer,
            'group_comments' => $groupComments,
            'status' => $status,
            'id_login' => Auth::user()->id,
            'order_revenue' => $orderRevenue,
            'last_contact' => $lastContact
        ]);
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $customer = $this->customerService->find($id);
        $input = $request->except(['image_contact']);
        $input['image'] = $request->image_contact;

        $input['user_id'] = Auth::user()->id;
        $input['customer_id'] = @$customer->id;

        $time = Customer::timeExpired($customer->status_id);
        $time['expired_time_boolean'] = StatusConstant::CHUA_QUA_HAN;
        $customer->update($time);

        $this->groupCommentService->create($input);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
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
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->groupCommentService->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except(['image_contact']);
        $input['image'] = $request->image_contact;

        return $this->groupCommentService->update($input, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->groupCommentService->delete($id);

        $request->session()->flash('error', 'Xóa tin nhắn thành công!');
    }

    public function chatAjax(Request $request)
    {
        $input = $request->all();

        $input['customer_id'] = $request->customer_id;
        $input['user_id'] = Auth::user()->id;

        $groupComment = GroupComment::create($input);

        $groupComment1 = GroupComment::with('user', 'customer')->where('id', $groupComment->id)->first();

        $customer = Customer::find($request->customer_id);
        $time = Customer::timeExpired($customer->status_id);
        $time['expired_time_boolean'] = StatusConstant::CHUA_QUA_HAN;
        $customer->update($time);

        return response()->json(['group_comment' => $groupComment1, 'id_login' => Auth::user()->id]);
    }
}
