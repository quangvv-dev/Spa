<?php

namespace App\Http\Controllers\BE;

use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Notification;
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
        $this->middleware('permission:report.tasks', ['only' => ['statistical']]);
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
        $branchs = Branch::pluck('name','id')->toArray();
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $admin = auth()->user();
        if (!$admin->permission('tasks.employee')) {
            $input['sale_id'] = Auth::user()->id;
        }
        if (isset($request->type) && $request->type) {
            $input['sale_id'] = Auth::user()->id;
        }
//        $user = User::whereIn('department_id',[UserConstant::TELESALES,UserConstant::WAITER,UserConstant::CSKH]);
        $docs = Task::search($input)->select('id', 'name', 'task_status_id', 'date_from','user_id')
            ->with(['user' => function ($query) {
                $query->select('avatar');
            }])->get();
        $new = [];
        $done = [];
        $fail = [];
        if (count($docs))
            foreach ($docs as $item) {
                if ($item->task_status_id == 1)
                    $new[] = $item;
                if ($item->task_status_id == 2)
                    $fail[] = $item;
                if ($item->task_status_id == 3)
                    $done[] = $item;
            }
        if ($request->ajax()) {
            return view('kanban_board.ajax', compact('new', 'done', 'fail'));
        }

        return view('kanban_board.index', compact('new', 'done', 'fail','branchs'));
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
        if ($request->description) {
            $note = str_replace("\r\n", ' ', $request->description);
            $note = str_replace("\n", ' ', $note);
            $note = str_replace('"', ' ', $note);
            $note = str_replace("'", ' ', $note);
            $request->merge(['description' => $note]);
        }
        $input = $request->except('user_id2');
        $task = $this->taskService->create($input);
        $user = User::find($request->user_id2);
        $task->users()->attach($user);

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
            foreach ($customer->categories as $item)
                $text[] = $item->name;
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

        return view('tasks._form-edit', compact('users', 'departments', 'users2', 'task', 'user', 'customers', 'type', 'priority', 'title', 'status', 'progress'));
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
        if ($request->description) {
            $note = str_replace("\r\n", ' ', $request->description);
            $note = str_replace("\n", ' ', $note);
            $note = str_replace('"', ' ', $note);
            $note = str_replace("'", ' ', $note);
            $request->merge(['description' => $note]);
        }
        $input = $request->except('user_id2', 'status_name');

        $task = $this->taskService->update($input, $id);
        $task->users()->sync($request->user_id2);

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
     * @param $id
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function statistical(Request $request)
    {
        if (empty($request->data_time)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }

        $data = Task::select('user_id', \DB::raw('count(id) as count'))->whereBetWeen('date_from', getTime($request->data_time))
            ->with('user')->groupBy('user_id')->get()->map(function ($item) use ($request) {
                $item->new = Task::where('user_id', $item->user_id)->where('task_status_id', 1)->whereBetWeen('date_from', getTime($request->data_time))->count();
                $item->success = Task::where('user_id', $item->user_id)->where('task_status_id', 3)->whereBetWeen('date_from', getTime($request->data_time))->count();
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statisticIndex(Request $request)
    {
        if (empty($request->data_time) && empty($request->start_date) && empty($request->end_date)) {
            $request->merge(['data_time' => 'THIS_MONTH']);
        }
        $users = User::where('role', UserConstant::TELESALES)->pluck('full_name', 'id')->toArray();

        $title = 'Danh sách công việc';
        $input = $request->all();
        $docs = Task::search($input)->paginate(StatusCode::PAGINATE_20);

        if ($request->ajax()) {
            return view('tasks.ajax_statistical', compact('docs'));
        }

        return view('tasks.statistical', compact('title', 'docs', 'users'));
    }

    /**
     * Update task
     *
     * @param Request $request
     * @param $id
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
     * @return mixed
     */
    public function findTask($id)
    {
        $task = $this->taskService->find($id);
        return $task;
    }
}
