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
        $input['type1'] = isset($input['type1']) ? $input['type1'] : 'qf2';
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
//        dd($input);
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
//        dd($input);
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
}
