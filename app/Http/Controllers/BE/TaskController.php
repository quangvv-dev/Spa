<?php

namespace App\Http\Controllers\BE;

use App\Models\Customer;
use App\Models\Task;
use App\Services\TaskService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    private $taskService;

    /**
     * TaskController constructor.
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
    public function index()
    {
        $type = Task::TYPE;
        $users = User::pluck('full_name', 'id');
        $customers = Customer::pluck('full_name', 'id');
        $priority = Task::PRIORITY;

        return view('tasks.index', compact('type', 'users', 'customers', 'priority'));
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
     * @param  \Illuminate\Http\Request  $request
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
