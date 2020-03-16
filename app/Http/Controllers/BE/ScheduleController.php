<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Category;
use App\Models\Customer;
use App\Services\TaskService;
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

    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
        $category = Category::pluck('name', 'id')->toArray();//nhóm KH
        $user = User::where('role', '<>', UserConstant::ADMIN)->get()->pluck('full_name', 'id');
        $staff = $user->toArray();
        $staff2 = $user->prepend('Tất cả người tạo', 0)->toArray();
        $color = [
//            1 => 'Chưa qua',
            2 => 'Đặt lịch',
            3 => 'Đến/mua',
            4 => 'Đến/chưa mua',
            5 => 'Hủy lịch',
            //            6 => 'Tất cả',
        ];
        view()->share([
            'staff'    => $staff,
            'staff2'   => $staff2,
            'color'    => $color,
            'category' => $category,
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
            'person_action' => Auth::user()->id,
            'creator_id'    => Auth::user()->id,
        ]);
        if ($request->note) {
            $note = str_replace("\r\n", ' ', $request->note);
            $request->merge(['note' => $note]);
        }
        $data = Schedule::create($request->all());
        $customer = Customer::find($id);
//        $person_action = User::find($request->person_action);
        $now = Carbon::now()->format('Y-m-d');
        if ($now != $data->date) {
            $date = Carbon::parse($data->date)->format('d/m/Y') . ' 07:00';
        } else {
            $date = '';
        }
//        if (isset($customer) && $customer) {
//            $body = setting('sms_cskh');
//            $body = str_replace('%full_name%', $customer->full_name, $body);
//            $body = str_replace('%time_from%', $data->time_from, $body);
//            $body = str_replace('%time_to%', $data->time_to, $body);
//            $body = Functions::vi_to_en($body);
//            Functions::sendSms(@$customer->phone, $body, $date);
//        }
//        if (isset($person_action) && $person_action) {
//            $body = setting('sms_csnv');
//            $body = str_replace('%full_name%', $person_action->full_name, $body);
//            $body = str_replace('%time_from%', $data->time_from, $body);
//            $body = str_replace('%time_to%', $data->time_to, $body);
//            $body = Functions::vi_to_en($body);
//            Functions::sendSms(@$person_action->phone, $body, $date);
//        }
        $input = [
            'customer_id'    => $id,
            'date_from'      => Carbon::now()->format('Y-m-d'),
            'time_from'      => '07:00',
            'date_to'        => $request->date,
            'time_to'        => $request->time_from,
            'code'           => 'CV-CSKH',
            'user_id'        => $request->person_action,
            'all_day'        => 'on',
            'priority'       => 1,
            'amount_of_work' => 1,
            'type'           => 2,
            'name'           => 'Công việc chăm sóc khách hàng',
            'description'    => 'Bạn có công việc CSKH với khách hàng ' . $customer->full_name . '---' . $customer->phone . ' đặt lịch hẹn. Trao đổi với KH : ' . $request->note,
        ];
        $task = $this->taskService->create($input);
        $user = User::find($request->user_id2);
        $task->users()->attach($user);
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
        if ($request->note) {
            $note = str_replace("\r\n", ' ', $request->note);
            $request->merge(['note' => $note]);
        }
        if (!empty($request->format_date)) {
            $date = $request->date;
        } else {
            $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        }
        $request->merge(['date' => $date]);
        $data = Schedule::find($request->id);
        $data->update($request->except('id', 'format_date'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $id)
    {
        $id->delete();
    }

    public function homePage(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');
        $docs = Schedule::search($request->all());
        $docs = $docs->get()->map(function ($item) use ($now) {
            $item->short_des = str_limit($item->note, $limit = 20, $end = '...');
            $check = Schedule::orderBy('id', 'desc')->where('date', $now)->with('creator')
                ->where('time_from', $item->time_from)->orWhere('time_to', $item->time_to);
            $item->count = $check->count();
            return $item;
        });
        $title = 'Danh sách lịch hẹn';
        $user = $request->user ?: 0;
        $customer = $request->customer ?: '';
        if ($request->ajax()) {
            return $docs;
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
