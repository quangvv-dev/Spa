<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Notification;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\TaskService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    private $taskService;

    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
//        $this->middleware('permission:report.tasks', ['only' => ['statistical']]);
        $this->middleware('permission:tasks.employee', ['only' => ['statisticIndex']]);

        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $color = Status::where('type', StatusCode::RELATIONSHIP)->pluck('color', 'id')->toArray();
        $branchs = Branch::pluck('name', 'id')->toArray();
        $location = Branch::getLocation();
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }

        $input = $request->all();
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        $admin = auth()->user();
        if (!$admin->permission('tasks.employee')) {
            $input['sale_id'] = Auth::user()->id;
        }

//        $user = User::whereIn('department_id',[UserConstant::TELESALES,UserConstant::WAITER,UserConstant::CSKH]);
        $docs = Task::search($input)->select('id', 'name', 'task_status_id', 'date_from', 'user_id', 'type',
            'customer_id')
            ->with('user', 'customer')->get();
        $new = [];
        $done = [];
        $fail = [];
        if (count($docs)) {
            foreach ($docs as $item) {
                if ($item->task_status_id == StatusConstant::TASK_TODO) {
                    $new[] = $item;
                }
                if ($item->task_status_id == StatusConstant::TASK_FAILED) {
                    $fail[] = $item;
                }
                if ($item->task_status_id == StatusConstant::TASK_DONE) {
                    $done[] = $item;
                }
            }
        }
        if ($request->ajax()) {
            return view('kanban_board.ajax', compact('new', 'done', 'fail', 'color'));
        }

        return view('kanban_board.index', compact('new', 'done', 'fail', 'branchs', 'location', 'color'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $customer = Customer::find($request->customer_id);
        $request->merge([
            'user_id'   => Auth::user()->id,
            'priority'  => 1,
            'branch_id' => $customer->branch_id,
        ]);
        $input = $request->except('ajax');
        if (Auth::user()->department_id == DepartmentConstant::TELESALES) {
            $input['type'] = StatusCode::GOI_LAI;
        } else {
            $input['type'] = StatusCode::CSKH;
        }
        $task = $this->taskService->create($input);
        $user = User::find($request->user_id2);
        $task->users()->attach($user);
        if ($request->ajax) {
            return back();
        }
        return redirect('tasks')->with('status', 'Tạo người dùng thành công');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeCustomer(Request $request)
    {
        if ($request->description) {
            $note = str_replace("\r\n", ' ', $request->description);
            $note = str_replace("\n", ' ', $note);
            $note = str_replace('"', ' ', $note);
            $note = str_replace("'", ' ', $note);
            $request->merge(['description' => $note]);
        }
        $input = $request->except('user_id2', 'status_name');
        $customer = Customer::find($input['customer_id']);
        $text = [];
        if (isset($customer->categories)) {
            foreach ($customer->categories as $item) {
                $text[] = $item->name;
            }
        }
        $input['name'] = $input['name'] . ' - ' . $customer->full_name . ' - ' . $customer->phone . ' nhóm ' . implode($text);
        $task = $this->taskService->create($input);
        $user = User::find($request->user_id2);
        $task->users()->attach($user);

//        $title = $task->type == NotificationConstant::CALL ? '💬💬💬 Bạn có công việc gọi điện mới !'
//            : '📅📅📅 Bạn có công việc chăm sóc mới !';
//        Notification::insert([
////            'title' => 'CV ' . $request->name . ' đã đến giờ thực hiện',
//            'title' => $title,
//            'user_id' => $task->user_id,
//            'type' => $task->type,
//            'task_id' => $task->id,
//            'status' => NotificationConstant::HIDDEN,
//            'created_at' => $task->date_from . ' ' . $task->time_from,
//            'data' => json_encode((array)['task_id' => $task->id]),
//        ]);
        return back();
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
        $task = $this->taskService->find($id);
        $users = User::get();
        $user = $task->users()->get()->pluck('id')->toArray();
        $users2 = User::pluck('full_name', 'id');
        $priority = Task::PRIORITY;
        $type = Task::TYPE;
        $customers = Customer::pluck('full_name', 'id');
        $title = 'Thay đổi công việc';
        $status = TaskStatus::pluck('name', 'id');
        $progress = Task::PROGRESS;
        $departments = Department::pluck('name', 'id');

        return view('tasks._form-edit',
            compact('users', 'departments', 'users2', 'task', 'user', 'customers', 'type', 'priority', 'title',
                'status', 'progress'));
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
//        if ($request->description) {
//            $note = str_replace("\r\n", ' ', $request->description);
//            $note = str_replace("\n", ' ', $note);
//            $note = str_replace('"', ' ', $note);
//            $note = str_replace("'", ' ', $note);
//            $request->merge(['description' => $note]);
//        }
        $input = $request->except('user_id2', 'status_name', 'ajax');
        $task = $this->taskService->update($input, $id);
        $task->users()->sync($request->user_id2);
        if ($request->ajax) {
            return back()->with('status', 'Cập nhật công việc thành công');
        }
        Notification::where('task_id', $task->id)->update(['created_at' => $task->date_from . ' ' . $task->time_from]);

        return redirect(route('tasks.index'))->with('status', 'Cập nhật công việc thành công');
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

    public function updateStatus(Request $request)
    {
        $taskStatus = TaskStatus::where('name', 'Hoàn thành')->first();
        $input = $request->all();
        $input['task_status_id'] = $taskStatus->id;
        $task = $this->taskService->find($request->id);
        $task->update($input);
    }

    /**
     * Update task
     *
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function ajaxUpdate(Request $request, $id)
    {
        if ($request->description) {
            $note = str_replace("\r\n", ' ', $request->description);
            $note = str_replace("\n", ' ', $note);
            $note = str_replace('"', ' ', $note);
            $note = str_replace("'", ' ', $note);
            $request->merge(['description' => $note]);
        }
        $input = $request->except('user_id2', 'status_name');
        $task = $this->taskService->update($input, $id);

//        Notification::where('task_id', $task->id)->update(['created_at' => $task->date_from . ' ' . $task->time_from]);

        return $task;
    }

    /**
     * Thong ke hieu qua cong viec
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function statistical(Request $request)
    {
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }

        $data = Task::select('user_id', \DB::raw('count(id) as count'))->whereBetWeen('date_from',
            getTime($request->data_time))
            ->with('user')->groupBy('user_id')->get()->map(function ($item) use ($request) {
                $item->new = Task::where('user_id', $item->user_id)->where('task_status_id',
                    1)->whereBetWeen('date_from', getTime($request->data_time))->count();
                $item->success = Task::where('user_id', $item->user_id)->where('task_status_id',
                    3)->whereBetWeen('date_from', getTime($request->data_time))->count();
                return $item;
            })->sortByDesc('count');

        if ($request->ajax()) {
            return Response::json(view('report_products.ajax_tasks', compact('data'))->render());
        }

        return view('report_products.index_tasks', compact('data'));
    }

    /**
     * Công việc theo sale
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statisticIndex(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $users = User::whereIn('department_id',
            [DepartmentConstant::TELESALES, DepartmentConstant::WAITER, DepartmentConstant::CSKH])
            ->pluck('full_name', 'id')->toArray();
        if (Auth::user()->department_id != DepartmentConstant::ADMIN) {
            if (!empty($request->role)) {
                $input['member'] = myTeamMember();
                $users = !empty($input['member']) ? User::whereIn('id', $input['member'])->pluck('full_name',
                    'id')->toArray() : collect();
            }
            if (empty($input['sale_id'])) {
                $input['sale_id'] = Auth::user()->id;
            }
        }



        $status = Task::groupByStatus($input)->get();
        $docs = Task::search($input)->paginate(StatusCode::PAGINATE_20);
        $status =  TaskStatus::select('id','name')->get()->transform(function ($item) use ($status) {
            return [
                'id'    => $item->id,
                'name'  => $item->name,
                'count' => @$status->firstWhere('id', $item->id)->count ?? 0,
            ];
        });

        if ($request->ajax()) {
            return view('tasks.ajax_statistical', compact('docs', 'status'));
        }

        return view('tasks.statistical', compact('docs', 'users', 'status'));
    }

    /**
     * Update task
     *
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function ajaxUpdateStatus(Request $request, $id)
    {
        $task = $this->taskService->find($id);
        $task->task_status_id = $request->task_status_id;
        $task->save();
        return 1;
    }

    /**
     * find task
     *
     * @param $id
     *
     * @return mixed
     */
    public function findTask($id)
    {
        $task = $this->taskService->find($id);
        return $task;
    }
}
