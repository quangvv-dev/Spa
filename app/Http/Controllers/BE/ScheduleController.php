<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\HistorySms;
use App\Models\Status;
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
        $this->middleware('permission:schedules.list', ['only' => ['index']]);
        $this->middleware('permission:schedules.edit', ['only' => ['edit']]);
        $this->middleware('permission:schedules.add', ['only' => ['create']]);
        $this->middleware('permission:schedules.delete', ['only' => ['destroy']]);

        $this->taskService = $taskService;
        $category = Category::pluck('name', 'id')->toArray();//nhóm KH
        $user = User::where('department_id', '<>', DepartmentConstant::ADMIN)->get()->pluck('full_name', 'id');
        $staff = $user->toArray();
        $staff2 = $user->prepend('Tất cả người tạo', 0)->toArray();
        $branchs = Branch::search()->pluck('name', 'id');

        $color = [
//            1 => 'Chưa qua',
            2 => 'Đặt lịch',
            3 => 'Đến/mua',
            4 => 'Đến/chưa mua',
            5 => 'Hủy lịch',
//            6 => 'Tất cả',
        ];
        view()->share([
            'staff' => $staff,
            'staff2' => $staff2,
            'color' => $color,
            'category' => $category,
            'branchs' => $branchs,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request, $id)
    {
        $docs = Schedule::orderBy('id', 'desc')->where('user_id', $id);
        if ($request->search) {
            $docs = $docs->where('name', 'like', '%' . $request->search . '%')
                ->orwhere('code', 'like', '%' . $request->search . '%')
                ->orwhere('parent_id', 'like', '%' . $request->search . '%');
        }
        $docs = $docs->paginate(StatusCode::PAGINATE_10);
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
        $customer = Customer::find($id);
        $category = CustomerGroup::where('customer_id', $customer->id)->first();
        $request->merge([
            'user_id' => $id,
            'person_action' => Auth::user()->id,
            'creator_id' => Auth::user()->id,
            'branch_id' => $customer->branch_id,
            'category_id' => isset($category) ? $category->category_id : 0,
        ]);
        if ($request->note) {
            $note = str_replace("\r\n", ' ', $request->note);
            $note = str_replace("\n", ' ', $note);
            $note = str_replace('"', ' ', $note);
            $note = str_replace("'", ' ', $note);
            $request->merge(['note' => $note]);
        }
        $data = Schedule::create($request->all());
        if (!empty(setting('sms_schedules'))) {
            $date = Functions::dayMonthYear($data->date);
            $text = setting('sms_schedules');
            $text = str_replace("%full_name%", @$data->customer->full_name, $text);
            $text = str_replace("%time_from%", @$data->time_from, $text);
            $text = str_replace("%time_to%", @$data->time_to, $text);
            $text = str_replace("%date%", @$date, $text);
            $text = str_replace("%branch%", @$customer->branch->name, $text);
            $text = str_replace("%phoneBranch%", @$customer->branch->phone, $text);
            $text = str_replace("%addressBranch%", @$customer->branch->address, $text);
            $text = Functions::vi_to_en($text);
            $err = Functions::sendSmsV3($data->customer->phone, @$text);
            if (isset($err) && $err) {
                HistorySms::insert([
                    'phone' => @$data->customer->phone,
                    'campaign_id' => 0,
                    'message' => $text,
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                    'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                ]);
            }
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->note) {
            $note = str_replace("\r\n", ' ', $request->note);
            $note = str_replace("\n", ' ', $note);
            $note = str_replace('"', ' ', $note);
            $note = str_replace("'", ' ', $note);
            $request->merge(['note' => $note]);
        }
        if (!empty($request->format_date)) {
            $date = $request->date;
        } else {
            $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        }
        $request->merge(['date' => $date]);
        $data = Schedule::with('customer')->find($request->id);
        $data->update($request->except('id', 'format_date'));

        if ($request->ajax()) {
            return $data;
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Schedule $id
     * @throws \Exception
     */
    public function destroy(Schedule $id)
    {
        $id->delete();
    }

    public function homePage(Request $request)
    {
        $status = Status::select('id', 'name')->where('type', StatusCode::SOURCE_CUSTOMER)->pluck('name', 'id')->toArray();
        $now = Carbon::now()->format('Y-m-d');
        if (!empty(Auth::user()->branch_id)) {
            $request->merge(['branch_id' => Auth::user()->branch_id]);
        }
        if (!count($request->all())) {
            $request->merge(['branch_id' => 1]);

        }
        $params = $request->all();
        $docs = Schedule::search($params)->has('customer')->with('customer');

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
        return view('schedules.home2', compact('status', 'title', 'docs', 'now', 'user', 'customer'));
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
            'data' => $status,
        ];
    }

    public function ajaxUpdate(Request $request, $id)
    {
        $input = $request->all();
        $schedule = Schedule::find($id);
        $schedule->update($input);

        return $schedule;
    }
}
