<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\ScheduleConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\CustomerPost;
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

class PostController extends BaseApiController
{
    /**
     * Update Post
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (isset($post) && $post) {
            $post->form_html = $request->form_html;
            $post->setting_form = $request->setting_form;
            $post->save();
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');
        }
        return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'BAD REQUEST');
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
