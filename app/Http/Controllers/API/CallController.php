<?php

namespace App\Http\Controllers\API;

use App\Constants\DepartmentConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Resources\CallCenterResource;
use App\Models\CallCenter;
use App\Models\HistorySms;
use App\Models\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CallController extends BaseApiController
{
    /**
     * Update Post
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function hangUp(Request $request)
    {
        if ($request->api_key != md5('quangphuong9685@gmail.com')) {
            return $this->responseApi(ResponseStatusCode::UNAUTHORIZED, 'API KEY WRONG');
        }
        $server = setting('server_call_center');
        if (isset($server) && $server == StatusCode::SERVER_GTC_TELECOM) {
            $status = $request->CallStatus == 'Answered' ? 'ANSWERED' : 'MISSED CALL';
            $direction = $request->Direction == 'Outgoing' ? 'INBOUND' : 'MISSED CALL';
            $input = [
                'caller_id'     => $request->CallId,
                'call_type'     => $direction,
                'start_time'    => $request->CallDate . ' ' . $request->CallDateTimeStart,
                'caller_number' => $request->ExtensionNumber,
                'dest_number'   => str_replace('+84', '0', $request->PhoneNumber),
                'answer_time'   => $request->Duration,
                'call_status'   => $status,
                'recording_url' => $request->RecordingPath,
            ];

        } else {
            $input = $request->only('caller_number', 'answer_time', 'dest_number', 'call_status', 'recording_url',
                'caller_id', 'call_type', 'start_time');
            if (!isset($input['answer_time'])) {
                $input['answer_time'] = $request->duration;
            }
        }

        $isset = CallCenter::where('caller_id', $request->caller_id)->first();
        if (empty($isset)) {
            if ($request->call_type != 'INBOUND') {
                $call_exits = CallCenter::where('dest_number', $input['dest_number'])->exists();
                if (!$call_exits && !empty(setting('miss_call_sms'))) {
                    $text = Functions::vi_to_en(setting('miss_call_sms'));
                    $err = Functions::sendSmsV3($input['dest_number'], @$text);
                    if (isset($err) && $err) {
                        HistorySms::insert([
                            'phone'       => $input['dest_number'],
                            'campaign_id' => 0,
                            'message'     => $text,
                            'created_at'  => Carbon::now('Asia/Ho_Chi_Minh'),
                            'updated_at'  => Carbon::now('Asia/Ho_Chi_Minh'),
                        ]);
                    }
                }
                CallCenter::insert($input);
            } else {
                return $this->responseApi(ResponseStatusCode::OK, 'CRM NOT SAVE INBOUND', $request->all());
            }
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $request->all());

        } else {
            return $this->responseApi(ResponseStatusCode::OK, ' EXISTS RECORD CALLER', $request->all());
        }
    }

    /**
     * Cuộc gọi đến GtcTelecom
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function inComing()
    {
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');
    }

    /**
     * Click to Call GtcTelecom (Cuộc gọi đi)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function callOut()
    {
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');
    }

    /**
     * Show data post
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::find($id);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $post);
    }

    /**
     * Danh sách tổng đài APP
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $docs = CallCenter::search($input);
        $answers = clone $docs;
        $answers = $answers->where('call_status', 'ANSWERED');

        $hours = floor(($answers->sum('answer_time') / 3600));
        $minutes = floor(($answers->sum('answer_time') % 3600) / 60);
        $sec = round(($answers->sum('answer_time') % 3600) % 60);
        $time_call = ($hours > 0 ? $hours . ' giờ ' : '') . ($minutes > 0 ? $minutes . ' phút ' : '') . ($sec > 0 ? $sec . ' giây' : '');

        $data['time_call'] = $time_call;
        $data['all_record'] = $docs->count();
        $data['answers'] = $answers->count();
        $data['miss'] = $docs->count() - $answers->count();

        $docs = $docs->paginate(StatusCode::PAGINATE_20);
        $data['lastPage'] = $docs->lastPage();

        $data['records'] = CallCenterResource::collection($docs);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * danh sach tong dai vien
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeCall(Request $request)
    {
        if ($request->type == 'all_sale') {
            $data = User::select('id', 'full_name', 'caller_number')->where('department_id',
                DepartmentConstant::TELESALES)->where('active', UserConstant::ACTIVE)->get();
        } else {
            $data = User::select('id', 'full_name', 'caller_number')->where('caller_number', '!=', '')->get();
            if (count($data) <= 0) {
                $data = User::select('id', 'full_name', 'caller_number')->where('department_id',
                    DepartmentConstant::TELESALES)->where('active', UserConstant::ACTIVE)->get();
            }
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }


}
