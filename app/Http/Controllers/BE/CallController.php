<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\CallCenter;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;


class CallController extends Controller
{


    public function __construct()
    {
        $telesales = User::whereNotNull('caller_number')->where('active', StatusCode::ON)->pluck('full_name', 'caller_number');
        $this->middleware('permission:call-center', ['only' => ['index']]);

        view()->share([
            'telesales' => $telesales,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Quản lý tổng đài';

        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $docs = CallCenter::search($input);
        $answers = clone $docs;
        $answers = $answers->where('call_status', 'ANSWERED');

        $docs = $docs->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('call_center.ajax', compact('docs', 'answers'));
        }
        return view('call_center.index', compact('title', 'docs', 'answers'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(CallCenter $id)
    {
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
     * @param int $id
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

    public function getStreamLink(CallCenter $id)
    {
        $doc = $id;
        return view('call_center.stream', compact('doc'));
    }
}
