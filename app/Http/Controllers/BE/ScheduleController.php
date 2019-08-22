<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Customer;
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
        $customer_plus = Customer::get()->pluck('full_name', 'id')->prepend('Tất cả khách hàng', 0)->toArray();
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
            'staff'         => $staff,
            'customer_plus' => $customer_plus,
            'staff2'        => $staff2,
            'color'         => $color,
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
        $data = Schedule::create($request->all());
        $customer = Customer::find($id);
        $person_action = User::find($request->person_action);
        $now = Carbon::now()->format('Y-m-d');
        if ($now != $data->date) {
            $date = Carbon::parse($data->date)->format('d/m/Y') . ' 07:00';
        } else {
            $date = '';
        }
        if (isset($customer) && $customer) {
            $body = setting('sms_cskh');
            $body = str_replace('%full_name%', $customer->full_name, $body);
            $body = str_replace('%time_from%', $data->time_from, $body);
            $body = str_replace('%time_to%', $data->time_to, $body);
            $body = Functions::vi_to_en($body);
            Functions::sendSms(@$customer->phone, $body, $date);
        }
        if (isset($person_action) && $person_action) {
            $body = setting('sms_csnv');
            $body = str_replace('%full_name%', $person_action->full_name, $body);
            $body = str_replace('%time_from%', $data->time_from, $body);
            $body = str_replace('%time_to%', $data->time_to, $body);
            $body = Functions::vi_to_en($body);
            Functions::sendSms(@$person_action->phone, $body, $date);
        }
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
        $now = Carbon::now()->format('Y-m-d');
        $docs = Schedule::with('customer')->orderBy('id', 'desc');
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
            $docs = $docs->where('creator_id', $request->user);
        }
        if ($request->customer) {
            $param = $request->customer;
            $docs->whereHas('customer', function ($q) use ($param) {
                $q->where('phone', 'like', '%' . $param . '%');
            });
        }
        $docs = $docs->get()->map(function ($item) use ($now) {
            $item->short_des = str_limit($item->note, $limit = 20, $end = '...');
            $check = Schedule::orderBy('id', 'desc')->where('date', $now)
                ->where('time_from', $item->time_from)->orWhere('time_to', $item->time_to)->get();
            $item->count = count($check);
            return $item;
        });

        $title = 'Danh sách lịch hẹn';
        $staff = User::where('role', '<>', UserConstant::ADMIN)->get()->pluck('full_name', 'id')->toArray();
        $user = $request->user ?: 0;
        $customer = $request->customer ?: '';
        if ($request->ajax()) {
            return Response::json(view('schedules.ajax2',
                compact('docs', 'title', 'now', 'staff', 'user'))->render());
        }
        return view('schedules.home2', compact('title', 'docs', 'now', 'user', 'customer'));
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

    public function getList(Request $request)
    {
        $status = Schedule::SCHEDULE_STATUS;
        $scheduleId = $request->id;

        return $data = [
            'schedule_id' => $scheduleId,
            'data'        => $status,
        ];;
    }

    public function ajaxUpdate(Request $request, $id)
    {
        $input = $request->all();

        $schedule = Schedule::find($id);
        $schedule->update($input);

        return $schedule;
    }
}
