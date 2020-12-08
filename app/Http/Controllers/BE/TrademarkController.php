<?php

namespace App\Http\Controllers\BE;

use App\Models\Trademark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrademarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Quản lý nhà cung cấp';
        $trademark = Trademark::get();
        return view('trademarks.index', compact('title', 'trademark'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input['name'] = 'Điền NCC';
        Trademark::create($input);
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trademark $trademark
     * @return \Illuminate\Http\Response
     */
    public function show(Trademark $trademark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trademark $trademark
     * @return \Illuminate\Http\Response
     */
    public function edit(Trademark $trademark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Trademark $trademark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trademark $trademark)
    {
        $trademark->update($request->all());
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trademark $trademark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trademark $trademark)
    {
        $trademark->delete();
    }
}
