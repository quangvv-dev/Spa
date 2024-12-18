<?php

namespace App\Http\Controllers\BE\ChamCong;

use App\Models\Reason;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReasonController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:reason.list', ['only' => ['index']]);
        $this->middleware('permission:reason.edit', ['only' => ['update']]);
        $this->middleware('permission:reason.add', ['only' => ['store']]);
        $this->middleware('permission:reason.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reasons = Reason::all();
        return view('cham_cong.reason.index',compact('reasons'));
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
        Reason::create($request->all());
        return 1;
//        dd($request->all());
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
        Reason::find($id)->update($request->all());
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Reason::find($id)->delete();
    }
}
