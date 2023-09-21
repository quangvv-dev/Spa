<?php

namespace App\Http\Controllers\API\CSKH;

use App\Constants\DepartmentConstant;
use App\Constants\OrderConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\SaleResource;
use App\Models\Branch;
use App\Models\CallCenter;
use App\Models\Customer;
use App\Models\GroupComment;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\Schedule;
use App\Services\CskhService;
use App\Services\SaleService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CskhController extends BaseApiController
{

    public function __construct(CskhService $cskh)
    {
        $this->cskh = $cskh;
    }

    public function index(Request $request)
    {
        if (isset($request->location_id)) {
            $group_branch = Branch::where('location_id', $request->location_id)->pluck('id')->toArray();
            $request->merge(['group_branch' => $group_branch]);
        }
        $input = $request->all();
        $tasks = $this->cskh->getDataTask($input);//công việc
        $orders = $this->cskh->getDataOrders($input);
        $data= $this->cskh->getDataNew($input);
        $payments = $this->cskh->getDataPayment($input);

        $users = $this->cskh->transformData($tasks, $orders, $data, $payments);
        $users =  usort_key_max($users->toArray(),'all_payment');
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $users);
    }
}
