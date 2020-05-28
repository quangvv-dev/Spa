<?php

namespace App\Http\Controllers\BE;

use App\Constants\UserConstant;
use App\Models\Customer;
use App\Models\Department;
use App\Models\OrderDetail;
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
        $users = User::where('role', UserConstant::TELESALES)->get()->map(function ($item) {
            $data_new = Customer::select('id')->where('telesales_id', $item->id)->whereMonth('created_at', '5')
                ->whereYear('created_at', '2020');
            $data_old = Customer::select('id')->where('telesales_id', $item->id)->whereMonth('created_at', '<=', '5')
                ->whereYear('created_at', '2020');
            $order_new = OrderDetail::whereIn('user_id', $data_new->pluck('id')->toArray());
            $order_old = OrderDetail::whereMonth('created_at', '5')
                ->whereYear('created_at', '2020')->whereIn('user_id', $data_old->pluck('id')->toArray());

            $item->customer_new = $data_new->get()->count();
            $item->order_new = $order_new->count();
            $item->order_old = $order_old->count();
            $item->revenue_new = $order_new->sum('total_price');
            $item->revenue_old = $order_old->sum('total_price');
//            $item->revenue_total = (int)$item->revenue_new + (int)$item->revenue_old;
            return $item;
        });
//        dd($users);
        return view('report_products.sale', compact('users'));
    }
}
