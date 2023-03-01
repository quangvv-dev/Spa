<?php

namespace App\Http\Controllers\BE\ChamCong;

use App\Http\Controllers\BE\SettingController;
use App\Models\ChamCong;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $end = intval(Carbon::now()->endOfMonth()->format('d'));
        $user = User::select('id', 'full_name', 'approval_code')->get()->map(function ($item) use ($end) {
            $approval = [];
            for ($i = 1; $i <= $end; $i++) {
                $curentDate = Carbon::now()->startOfMonth()->addDays($i - 1)->format('Y-m-d');
                $docs = ChamCong::whereDate('date_time_record', $curentDate)->get()->toArray();
                if (count($docs) < 2) {
                    $approval[$i] = 0;

                } else {
                    $startDate = new Carbon($docs[0]['date_time_record']);
                    $endDate = new Carbon($docs[count($docs) - 1]['date_time_record']);
                    $diff = round((strtotime($startDate) - strtotime($endDate)) / 60 / 60, 1);
                    $approval[$i] = $diff > 9.5 ? 1 :round($diff / 9.5,2);
                }
            }
            $item->approval = $approval;
            return $item;
        })->filter(function ($fl) {
            if (!empty($fl->approval_code)){
                return $fl;
            }
        });
        return view('cham_cong.statistic.index', compact('end', 'docs'));
//        return view('cham_cong.statistic.index');
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
