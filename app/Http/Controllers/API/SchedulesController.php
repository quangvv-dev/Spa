<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Constants\UserConstant;
use App\Http\Resources\SchedulesResource;
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
        $request->merge(['type' => 'list_schedules']);
        $user = $request->jwtUser;
        $params = $request->except('type');
        $params['branch_id'] = isset($request->branch_id) ? $request->branch_id : $user->branch_id;
        if (empty($request->start_date) || empty($request->end_date)) {
            $params['start_date'] = Carbon::now()->format('Y-m-d');
            $params['end_date'] = $params['start_date'];
        }
        unset($params['status']);
        $params['status_id'] = isset($request->status) ? $request->status : '';
        $docs = Schedule::search($params)->has('customer')->with('customer:id,full_name,phone', 'creator:id,full_name')
            ->select('id', 'creator_id', 'user_id', 'date', 'note', 'status','time_from','time_to','user_id', 'branch_id')
            ->paginate(StatusCode::PAGINATE_20);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', SchedulesResource::collection($docs));
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
            [
                'id'   => ScheduleConstant::QUA_HAN,
                'name' => 'Quá hạn',
            ],
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function update(Request $request)
    {
        if ($request->note) {
            $note = str_replace("\r\n", ' ', $request->note);
            $note = str_replace("\n", ' ', $note);
            $note = str_replace('"', ' ', $note);
            $note = str_replace("'", ' ', $note);
            $request->merge(['note' => $note]);
        }
        $data = Schedule::with('customer')->find($request->id);
        $data->update($request->except('id', 'format_date'));
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');
    }
}
