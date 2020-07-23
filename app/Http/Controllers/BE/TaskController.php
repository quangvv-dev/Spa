<?php

namespace App\Http\Controllers\BE;

use App\Models\Customer;
use App\Models\Department;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\TaskService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $now = Carbon::now()->format('Y-m-d');
        $input['type1'] = isset($input['type1']) ? $input['type1'] : 'qf1';
        $type = Task::TYPE;
        $users = User::pluck('full_name', 'id');
        $user = $request->user ?: 0;
        $docs = Task::getAll($input);
        $taskStatus = TaskStatus::getAll($input)->pluck('name', 'id')->toArray();

        if ($request->ajax()) {
            return $docs;
        }

        return view('tasks.index', compact(
            'type', 'now', 'user',
            'users',
            'docs',
            'taskStatus'
        ));
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
        $input = $request->except('user_id2', 'status_name');
        $task = $this->taskService->create($input);
        $user = User::find($request->user_id2);
        $task->users()->attach($user);
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
        $input = $request->except('user_id2', 'status_name');

        $task = $this->taskService->update($input, $id);
        $task->users()->sync($request->user_id2);

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
        $input = $request->except('user_id2', 'status_name');
        $task = $this->taskService->update($input, $id);
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
}
