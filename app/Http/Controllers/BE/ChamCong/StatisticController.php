<?php

namespace App\Http\Controllers\BE\ChamCong;

use App\Http\Controllers\BE\SettingController;
use App\Models\ChamCong;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:approval', ['only' => ['index','store','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = now()->format('Y');
        if ($request->month) {
            $end = Carbon::create($year, $request->month)->endOfMonth()->format('d');
        } else {
            $end = now()->endOfMonth()->format('d');
        }
        $docs = User::select('id', 'full_name', 'approval_code', 'branch_id')->get()->map(function ($item) use ($end, $year, $request) {
            $approval = [];
            $late = [];
            $early = [];
            for ($i = 1; $i <= $end; $i++) {
                $curentDate = $request->month ? Carbon::create($year, $request->month)->startOfMonth()->addDays($i - 1)->format('Y-m-d')
                    : now()->startOfMonth()->addDays($i - 1)->format('Y-m-d');

                $docs = ChamCong::where('ind_red_id', $item->approval_code)->whereDate('date_time_record', $curentDate)->get()->toArray();
                if ($item->approval_code) {
                    if (count($docs) < 2) {
                        $approval[$i] = 0;

                    } else {
                        $startDate = new Carbon($docs[0]['date_time_record']);
                        $endDate = new Carbon($docs[count($docs) - 1]['date_time_record']);
                        $diff = round((strtotime($endDate) - strtotime($startDate)) / 60 / 60, 1);
                        $approval[$i] = $diff > 9.5 ? 1 : round($diff / 9.5, 2);
                        $late[] = (strtotime($startDate->format('H:i')) - strtotime('08:00')) / 60;
                        $early[] = (strtotime($endDate->format('H:i')) - strtotime('17:30')) / 60;
                    }
                } else {
                    $approval[$i] = 0;
                }
            }
            $item->approval = $approval;
            $item->late = $late;
            return $item;
        })->filter(function ($fl) {
            if (!empty($fl->approval_code)) {
                return $fl;
            }
        });
        return view('cham_cong.statistic.index', compact('end', 'docs'));
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
        $abc = DB::table('Settings')->where('setting_key', 2)->first();
        $abc = \GuzzleHttp\json_decode($abc->setting_value);

//        ChamCong::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
