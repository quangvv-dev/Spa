<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\CustomerPost;
use App\Models\CallCenter;
use App\Models\Campaign;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentHistory;
use App\Models\Post;
use App\Models\Status;
use App\Models\Task;
use App\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Models\Category;
use App\Helpers\Functions;
use App\Constants\UserConstant;
use App\Models\GroupComment;

class CallController extends BaseApiController
{
    /**
     * Update Post
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function hangUp(Request $request)
    {
        if ($request->api_key != md5('quangphuong9685@gmail.com')) {
            return $this->responseApi(ResponseStatusCode::UNAUTHORIZED, 'API KEY WRONG');
        }
        $input = $request->only('caller_number', 'dest_number', 'answer_time', 'call_status', 'recording_url', 'caller_id', 'call_type', 'start_time');

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::find($id);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $post);
    }
}
