<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Models\Customer;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupComment;
use Illuminate\Support\Facades\Auth;

class GroupCommentController extends Controller
{
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
        $customer = Customer::find($id);
        $groupComments = GroupComment::with('user', 'customer')
            ->where('customer_id', $id)
            ->orderBy('id', 'desc')
            ->take(3)->get();
        $status = Status::where('type', StatusCode::RELATIONSHIP)->get();

        return response()->json([
            'customer' => $customer,
            'group_comments' => $groupComments,
            'status' => $status
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
    public function store(Request $request, Customer $id)
    {
        $customer = $id;
        $request->merge([
            'customer_id' => @$customer->id,
            'user_id'     => Auth::user()->id,
        ]);
        GroupComment::create($request->all());
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
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
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function chatAjax(Request $request)
    {
        $input = $request->all();

        $input['customer_id'] = $request->customer_id;
        $input['user_id'] = Auth::user()->id;

        $groupComment = GroupComment::create($input);

        $groupComment1 = GroupComment::with('user', 'customer')->where('id', $groupComment->id)->first();

        return response()->json(['group_comment' => $groupComment1]);
    }
}
