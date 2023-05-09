<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Constants\UserConstant;
use App\Models\ChamCong;
use App\Models\Salary;
use App\Models\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Description;

class SchedulesController extends BaseApiController
{
    public function index(Request $request)
    {
        $validate = ['start_date' => "required", 'end_date' => "required"];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $user = $request->jwtUser;
        $params = $request->all();
        $params['branch_id'] = $user->branch_id;
        if (empty($request->start_date) || empty($request->end_date)) {
            $params['start_date'] = Carbon::now()->format('Y-m-d');
            $params['end_date'] = $params['start_date'];
        }
        $docs = Schedule::search($params)->has('customer')->with('customer:id,full_name,phone', 'creator:id,full_name')
            ->select('id', 'creator_id', 'user_id', 'date', 'note', 'status',
                'branch_id')->paginate(StatusCode::PAGINATE_20);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);
    }

    public function statusSchedules()
    {
        $data = [
            [
                'id'   => ScheduleConstant::DAT_LICH,
                'name' => 'Đặt lịch',
            ],
            [
                'id'   => ScheduleConstant::DEN_MUA,
                'name' => 'Đến mua',
            ],
            [
                'id'   => ScheduleConstant::CHUA_MUA,
                'name' => 'Đến chưa mua',
            ],
            [
                'id'   => ScheduleConstant::HUY,
                'name' => 'Hủy',
            ],
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }
}
