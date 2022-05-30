<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\DepartmentConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Http\Resources\AppCustomers\ServiceResource;
use App\Http\Resources\SchedulesResource;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\HistorySms;
use App\Models\Landipage;
use App\Models\Schedule;
use App\Models\Services;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulesController extends BaseApiController
{

    public function __construct()
    {
        //coding
    }

    /**
     * Danh sách lịch hẹn
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $customer = $request->jwtUser;
        $validate = [
            'status' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $request->merge(['type' => 'detail_schedules']);
        if ($request->status == 1){
            $schedules = Schedule::where('user_id', $customer->id)->where('status',ScheduleConstant::DAT_LICH)->paginate(StatusCode::PAGINATE_10);
        }else{
            $schedules = Schedule::where('user_id', $customer->id)->whereIn('status',ScheduleConstant::DAT_LICH)->paginate(StatusCode::PAGINATE_10);
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', SchedulesResource::collection($schedules));
    }

    /**
     *Tạo lịch hẹn
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validate = [
            'service_id' => "required",
            'date' => "required",
            'time_from' => "required",
            'time_to' => "required",
            'branch_id' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }

        $customer = $request->jwtUser;
        $category = CustomerGroup::where('customer_id', $request->customer_id)->first();
        $user = User::where('department_id', DepartmentConstant::WAITER)->first();
        $service = Services::select('name')->whereIn('id', $request->service_id)->pluck('name')->toArray();
        $input = $request->all();
        $request->merge([
            'user_id'       => $customer->id,
            'person_action' => isset($user) ? $user->id : 0,
            'creator_id'    => isset($user) ? $user->id : 0,
            'branch_id'     => $request->branch_id,
            'date'          => $request->date,
            'status'        => ScheduleConstant::DAT_LICH,
            'category_id'   => isset($category) ? $category->category_id : 0,
            'note'          => 'DV quan tâm: ' . implode($service, ','),
        ]);

        $data = Schedule::create($request->except('service_id'));

        if (!empty(setting('sms_schedules'))) {
            $date = Functions::dayMonthYear($data->date);
            $text = setting('sms_schedules');
            $text = str_replace("%full_name%", @$data->customer->full_name, $text);
            $text = str_replace("%time_from%", @$data->time_from, $text);
            $text = str_replace("%time_to%", @$data->time_to, $text);
            $text = str_replace("%date%", @$date, $text);
            $text = str_replace("%branch%", @$data->branch->name, $text);
            $text = str_replace("%phoneBranch%", @$data->branch->phone, $text);
            $text = str_replace("%addressBranch%", @$data->branch->address, $text);
            $text = Functions::vi_to_en($text);
            $err = Functions::sendSmsV3($data->customer->phone, @$text);
            if (isset($err) && $err) {
                HistorySms::insert([
                    'phone' => @$data->customer->phone,
                    'campaign_id' => 0,
                    'message' => $text,
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                    'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                ]);
            }
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

}