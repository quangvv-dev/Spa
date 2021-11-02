<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Resources\CallCenterResource;
use App\Models\CallCenter;
use App\Models\Post;
use App\User;
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
        $input = $request->only('caller_number', 'dest_number', 'answer_time', 'call_status', 'recording_url',
            'caller_id', 'call_type', 'start_time');

        $isset = CallCenter::where('caller_id', $request->caller_id)->first();
        if (empty($isset) && $request->call_type != 'INBOUND') {
            CallCenter::insert($input);

        }
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
        $data = User::select('id','full_name','caller_number')->where('caller_number','!=','')->get();
        if (count($data)<0){
            $data = User::select('id','full_name','caller_number')->whereIn('role',
                [UserConstant::TP_SALE, UserConstant::TELESALES, UserConstant::WAITER])->get();
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }


}
