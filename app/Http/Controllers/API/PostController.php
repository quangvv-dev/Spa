<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Models\Post;
use Illuminate\Http\Request;

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
