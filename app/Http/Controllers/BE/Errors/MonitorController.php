<?php

namespace App\Http\Controllers\BE\Errors;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Helpers\Functions;
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
        $this->middleware('permission:errors.monitoring.list', ['only' => ['index']]);
        $this->middleware('permission:errors.monitoring.edit', ['only' => ['edit']]);
        $this->middleware('permission:errors.monitoring.add', ['only' => ['create']]);
        $this->middleware('permission:errors.monitoring.delete', ['only' => ['destroy']]);
        $errors = Errors::orderByDesc('id');
        $position = clone $errors;
        $classify = clone $errors;
        $block = clone $errors;
        view()->share([
            'position' => $position->where('type', Errors::POSITION)->pluck('name', 'id')->toArray(),
            'classify' => $classify->where('type', Errors::CLASSIFY)->pluck('name', 'id')->toArray(),
            'block' => $block->where('type', Errors::BLOCK)->pluck('name', 'id')->toArray(),
            'error' => $errors->where('type', Errors::ERROR)->pluck('name', 'id')->toArray(),
            'users' => User::select('id', 'full_name')->pluck('full_name', 'id')->toArray(),
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
        $monitoring = Monitor::search($input);
        $allCurrent = $monitoring->count();
        $employee = clone $monitoring;
        $countTypeError = clone $monitoring;
        $employee = $employee->groupBy('user_id')->count();
        $countTypeError = $countTypeError->groupBy('error_id')->count();
        $monitoring = $monitoring->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('errors.monitoring.ajax', compact('monitoring','allCurrent','employee','countTypeError'));
        }
        return view('errors.monitoring.index', compact('monitoring','allCurrent','employee','countTypeError'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('errors.monitoring._form');
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
     * @param Monitor $monitoring
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Monitor $monitoring)
    {
        return view('errors.monitoring._form', compact('monitoring'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Monitor $monitoring
     * @return \Illuminate\Http\RedirectResponse|int
     */
    public function update(Request $request, Monitor $monitoring)
    {
        $monitoring->update($request->all());
        if ($request->ajax()){
            return 1;
        }
        return back()->with('status','Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     * @param Monitor $monitoring
     * @return array|int
     * @throws \Exception
     */
    public function destroy(Monitor $monitoring)
    {
        if ($monitoring->status == Monitor::ACTIVE){
            return [
                'code' => ResponseStatusCode::INTERNAL_SERVER_ERROR,
                'message' => "Biên bản đã duyệt không thể xóa",
            ];
        }
        $monitoring->delete();
        return 1;
    }
}
