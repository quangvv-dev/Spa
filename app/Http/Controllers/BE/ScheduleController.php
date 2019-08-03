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
        $staff2 = User::where('role', '<>', UserConstant::ADMIN)->get()->pluck('full_name', 'id')
            ->prepend('Tất cả nhân viên', 0)->toArray();
        $color = [
            1 => 'Hẹn gọi lại',
            2 => 'Đặt lịch',
            3 => 'Đã đến',
            4 => 'Không đến',
            5 => 'Hủy',
            6 => 'Tất cả',
        ];
        view()->share([
            'staff'  => $staff,
            'staff2' => $staff2,
            'color'  => $color,
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
        $docs = Schedule::orderBy('id', 'desc')->get()->map(function ($item) use ($now) {
            $item->short_des = str_limit($item->note, $limit = 20, $end = '...');
            $check = Schedule::orderBy('id', 'desc')->where('date', $now)
                ->where('time_from', $item->time_from)->orWhere('time_to', $item->time_to)->get();
            $item->count = count($check);
            return $item;
        });
        if ($request->search) {
            if ($request->search != 6) {
                $docs = $docs->where('status', $request->search);
            }
        }
        if ($request->date) {
            $docs = $docs->where('date', $request->date);
            $now = $request->date;
        }
        if ($request->user) {
            $docs = $docs->where('user_id', $request->user);
        }
        $title = 'Danh sách lịch hẹn';
        $staff = User::where('role', '<>', UserConstant::ADMIN)->get()->pluck('full_name', 'id')->toArray();
        $user = $request->user ?: 0;
        if ($request->ajax()) {
            return Response::json(view('schedules.ajax2',
                compact('docs', 'title', 'now', 'staff', 'user'))->render());
        }
        return view('schedules.home2', compact('title', 'docs', 'now', 'user'));
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
