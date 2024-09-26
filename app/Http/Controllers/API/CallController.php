<?php

namespace App\Http\Controllers\API;

use App\Constants\DepartmentConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Resources\CallCenterResource;
use App\Models\CallCenter;
use App\Models\Customer;
use App\Models\HistorySms;
use App\Models\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

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
        if ($request->api_key != md5('quangphuong9685@gmail.com') && $request->header('authorization') != md5('quangphuong9685@gmail.com')) {
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
        } elseif (isset($server) && $server == StatusCode::SERVER_CGV_TELECOM) {
            if (!in_array(strtoupper($request->status), ['ANSWERED', 'BUSY'])) {
                return $this->responseApi(ResponseStatusCode::MOVED_PERMANENTLY, 'CRM ONLY SAVE ANSWERED & BUSY',
                    $request->all());
            }
            $status = strtoupper($request->status) == 'ANSWERED' ? 'ANSWERED' : (strtoupper($request->status) == 'BUSY' ? 'MISSED CALL' : 'NOT-AVAILABLE');
            $input = [
                'caller_id'     => $request->call_id,
                'call_type'     => strtoupper($request->direction),
                'start_time'    => $request->time_started,
                'caller_number' => $request->from_number,
                'dest_number'   => $request->to_number,
                'answer_time'   => $request->duration,
                'call_status'   => $status,
                'recording_url' => $request->recording_url,
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
                CallCenter::create($input);
            } else {
                return $this->responseApi(ResponseStatusCode::MOVED_PERMANENTLY, 'CRM NOT SAVE INBOUND',
                    $request->all());
            }
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $request->all());

        } else {
            return $this->responseApi(ResponseStatusCode::MOVED_PERMANENTLY, ' EXISTS RECORD CALLER', $request->all());
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

    public function getAccountCode(Request $request)
    {
        if ($request->api_key != md5('quangphuong9685@gmail.com')) {
            return $this->responseApi(ResponseStatusCode::UNAUTHORIZED, 'API KEY WRONG');
        }
        $user = Customer::select('account_code')->where('phone', $request->phone)->first();
        if (empty($user)) {
            return $this->responseApi(ResponseStatusCode::NOT_FOUND, 'NOT FOUND');
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $user);
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

    public function clickToCall(Request $request)
    {
        $user = User::find($request->jwtUser->id);
        if (empty($user->caller_number)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Tài khoản chưa có mã tổng đài!');
        }
        $accessToken = '88d4b615ef0c4afdb3485fce4d90a300-ZDZmZTRkMmUtM2UxOS00ZjMzLWIzOTUtOGEzNmRkMWQ2Mzc5';
        $header = ['Authorization' => 'Bearer ' . $accessToken];
        $url = 'https://api.mobilesip.vn/v1/click2call/async?ext=' . $user->caller_number . '&phone=' . $this->encryptedPhoneNumber($request->phone) . '&is_encode=true&encrypt_method=aes';
        try {
            $response = GuzzleHttpCall($url, 'GET', $header);
            return $this->responseApi(ResponseStatusCode::OK, 'Kết nối cuộc gọi thành công!', $response);
        } catch (\Exception $exception) {
            return $this->responseApi(ResponseStatusCode::INTERNAL_SERVER_ERROR, 'Kết nối cuộc gọi thất bại!',
                ['error' => $exception->getMessage()]);
        }
    }

    function encryptedPhoneNumber($phoneNumber)
    {
        // Khóa mã hóa 32 byte tương đương với AES-256
        $key = 'PBX3ttnMJNS3274M2zVRtR738d5HByjc';
        // Mã hóa AES-256 với chế độ ECB và PKCS7 padding
        $encrypted = openssl_encrypt(
            $phoneNumber,            // Dữ liệu cần mã hóa
            'aes-256-ecb',           // Thuật toán mã hóa AES với 256-bit key, ECB mode
            $key,                    // Khóa mã hóa
            OPENSSL_RAW_DATA          // Output trả về dữ liệu nhị phân (binary)
        );
        // Chuyển kết quả mã hóa thành chuỗi hexadecimal
        return bin2hex($encrypted);
    }

}
