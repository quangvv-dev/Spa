<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use function MongoDB\BSON\toJSON;

class ScheduleController extends Controller
{

    public function __construct()
    {
        $staff = User::where('role', '<>', UserConstant::ADMIN)->get()->pluck('full_name', 'id')->toArray();
        view()->share([
            'staff' => $staff,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $docs = Schedule::orderBy('id', 'desc')->where('user_id', $id);
        if ($request->search) {
            $docs = $docs->where('name', 'like', '%' . $request->search . '%')
                ->orwhere('code', 'like', '%' . $request->search . '%')
                ->orwhere('parent_id', 'like', '%' . $request->search . '%');
        }
        $docs = $docs->paginate(10);
        $title = 'Danh sách lịch hẹn';
        if ($request->ajax()) {
            return Response::json(view('schedules.ajax', compact('docs', 'title', 'id'))->render());
        }
        return view('schedules.index', compact('title', 'docs', 'id'));
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
        $request->merge([
            'user_id'       => $id,
            'person_action' => $request->person_action,
            'creator_id'    => Auth::user()->id,
        ]);
        Schedule::create($request->all());
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
        if ($id) {
            $data = Schedule::find($id);
            return $data;
        }
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
        $data = Schedule::find($request->id);
        $data->update($request->except('id'));
        return redirect()->back();
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

    public function homePage(Request $request)
    {
//        $year = Carbon::now()->format('Y');
//        $date = new DateTime($now);
//        $week = $date->format("W");
//        $week_array = self::getStartAndEndDate($week, $year);
//        $docs = Schedule::orderBy('id', 'desc')->where('date', '>=', $week_array['week_start'])
//            ->where('date', '<=', $week_array['week_end'])->get();
//        if ($request->search) {
//            $docs = $docs->where('name', 'like', '%' . $request->search . '%')
//                ->orwhere('code', 'like', '%' . $request->search . '%')
//                ->orwhere('parent_id', 'like', '%' . $request->search . '%');
//        }
        $now = Carbon::now()->format('Y-m-d');
        $docs = Schedule::orderBy('id', 'desc')->where('date', $now)->get()->map(function ($item) use ($now) {
            $item->short_des = str_limit($item->note, $limit = 20, $end = '...');
            $check = Schedule::orderBy('id', 'desc')->where('date', $now)
                ->where('time_from', $item->time_from)->orWhere('time_to', $item->time_to)->get();
//            dd(strtotime($item->time_to));
//            1562488200
//            1562490000
            $item->count = count($check);
            return $item;
        });
        $title = 'Danh sách lịch hẹn';
        return view('schedules.home2', compact('title', 'docs', 'now'));
    }

    /**
     * Tính ra số ngày trong tuần từ số tuần và năm
     *
     * @param $week
     * @param $year
     *
     * @return mixed
     * @throws \Exception
     */
    public function getStartAndEndDate($week, $year)
    {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }
}
