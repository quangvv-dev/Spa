<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\GroupCommentResource;
use App\Models\Customer;
use App\Models\GroupComment;
use Illuminate\Http\Request;

class GroupCommentController extends BaseApiController
{
    public function index(Customer $customer)
    {
        $comment = $customer->groupComments()->paginate(StatusCode::PAGINATE_10);
        $data = [
            'currentPage' => $comment->currentPage(),
            'lastPage' => $comment->lastPage(),
            'record' => GroupCommentResource::collection($comment),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function store(Request $request, Customer $customer)
    {
        $request->merge([
            'user_id' => $request->jwtUser->id,
            'customer_id' => $customer->id,
        ]);
        $data = GroupComment::create($request->all());
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', new GroupCommentResource($data));
    }
}
