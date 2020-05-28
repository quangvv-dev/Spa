<?php

namespace App\Http\Controllers\BE;

use App\Models\Customer;
use App\Models\Department;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\TaskService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SalesController extends Controller
{
    private $taskService;

    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {

    }

    public function index(Request $request)
    {
        $input = $request->all();
        $users = User::get();
        dd($users);
        $countCustomer = Customer::groupBy('telesales_id')->get()->map(function ($item) {
        });
        dd($countCustomer);
//        $data =
        return view('report_products.sale');
    }
}
