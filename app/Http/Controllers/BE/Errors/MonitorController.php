<?php

namespace App\Http\Controllers\BE\Errors;

use App\Models\Errors;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|
     * \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $data = Errors::when(isset($input['type']) && $input['type'], function ($q) use ($input) {
            $q->where('type', $input['type']);
        })->when(isset($input['name']) && $input['name'], function ($q) use ($input) {
            $q->where('name', 'like', '%' . $input['name'] . '%');
        })->orderByDesc('id')->paginate(20);
        if ($request->ajax()) {
            return view('errors.reason.ajax', compact('data'));
        }
        return view('errors.reason.index', compact('data'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Errors::create([
            'name' => 'Điền lỗi...',
            'type' => Errors::POSITION,
        ]);
        return back();
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
    public function update(Request $request, Errors $reason)
    {
        $reason->update($request->all());
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Errors $reason)
    {
        $reason->delete();
        return 1;
    }
}
