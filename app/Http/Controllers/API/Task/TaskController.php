<?php

namespace App\Http\Controllers\API\Task;

use App\Constants\DepartmentConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\ChamCong\CustomerResource;
use App\Http\Resources\TasksResource;
use App\Models\Album;
use App\Models\Customer;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\TaskService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TaskController extends BaseApiController
{

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request, Customer $customer)
    {
        $request->merge(['api_type' => 'list_tasks']);
        $tasks = Task::where('customer_id', $customer->id)->orderByDesc('date_from')->paginate(10);
        $data = [
            'lastPage' => $tasks->lastPage(),
            'records'  => TasksResource::collection($tasks),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function store(Request $request)
    {
        $validate = [
            'customer_id' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $customer = Customer::find($request->customer_id);
        $request->merge([
            'user_id'       => $request->jwtUser->id,
            'taskmaster_id' => $request->jwtUser->id,
            'priority'      => 1,
            'branch_id'     => $customer->branch_id,
        ]);
        $input = $request->all();
        $input['type'] = StatusCode::GOI_LAI;
        if ($input['type'] == 3 && $request->jwtUser->department_id != DepartmentConstant::CSKH) {
            $input['type'] = StatusCode::GOI_LAI;
        } elseif ($input['type'] == 3 && $request->jwtUser->department_id == DepartmentConstant::CSKH) {
            $input['type'] = StatusCode::CSKH;
        }

        if ($request->type == StatusCode::GOI_LAI) {
            $input['user_id'] = $customer->telesales_id;
        } else {
            if ($request->type == StatusCode::CSKH) {
                $input['user_id'] = @$customer->cskh ?? $customer->telesales_id;
            }
        }
        $task = $this->taskService->create($input);
        $request->merge(['api_type' => 'list_tasks']);
        return $this->responseApi(ResponseStatusCode::OK, 'Tạo lịch CSKH thành công !!', new TasksResource($task));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->task_status_id == 6) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Công việc quá hạn không thể thay đổi');
        }
        $task->update($request->all());
        $request->merge(['api_type' => 'list_tasks']);
        return $this->responseApi(ResponseStatusCode::OK, 'Tạo lịch CSKH thành công !!', new TasksResource($task));
    }

    public function taskStatus()
    {
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', TaskStatus::select('id', 'name')->get());
    }

    public function taskType()
    {
        $data = [
            [
                'id'   => 3,
                'name' => 'Của tôi',
            ],
            [
                'id'   => 1,
                'name' => 'Gọi lại (phân bổ cho Telesale)',
            ],
            [
                'id'   => 2,
                'name' => 'CSKH (phân bổ cho CSKH)',
            ],
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', collect($data));
    }

    public function destroy(Task $task)
    {
        if ($task->task_status_id != 1) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Công việc đã xử lý không thể xóa !');
        }
        $task->delete();
        return $this->responseApi(ResponseStatusCode::OK, 'Xóa công việc thành công !');
    }
}
