<?php

namespace App\Http\Controllers\BE\Errors;

use App\Models\Errors;
use App\Models\Monitor;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MonitorController extends Controller
{
    public function __construct()
    {
        $errors = Errors::orderByDesc('id');
        $position = clone $errors;
        $classify = clone $errors;
        $block = clone $errors;
        view()->share([
            'position' => $position->where('type', Errors::POSITION)->pluck('name', 'id')->toArray(),
            'classify' => $classify->where('type', Errors::CLASSIFY)->pluck('name', 'id')->toArray(),
            'block' => $block->where('type', Errors::BLOCK)->pluck('name', 'id')->toArray(),
            'error' => $errors->where('type', Errors::ERROR)->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|
     * \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $monitoring = Monitor::when(isset($input['type']) && $input['type'], function ($q) use ($input) {
            $q->where('type', $input['type']);
        })->when(isset($input['name']) && $input['name'], function ($q) use ($input) {
            $q->where('name', 'like', '%' . $input['name'] . '%');
        })->orderByDesc('id')->paginate(20);
        if ($request->ajax()) {
            return view('errors.monitoring.ajax', compact('monitoring'));
        }
        return view('errors.monitoring.index', compact('monitoring'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $users = User::select('id', 'full_name')->pluck('full_name', 'id')->toArray();
        return view('errors.monitoring._form', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->merge(['owner_id' => Auth::user()->id]);
        Monitor::create($request->all());
        return back()->with('status', 'Tạo mới đơn giám sát');
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
