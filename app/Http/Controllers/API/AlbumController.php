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

class AlbumController extends BaseApiController
{
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

}
