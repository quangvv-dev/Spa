<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Resources\GroupCommentResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class GroupCommentController extends BaseApiController
{
    public function index(Customer $customer)
    {
       $comment = $customer->groupComments()->paginate(StatusCode::PAGINATE_10);
        $data = [
            'currentPage' => $comment->currentPage(),
            'lastPage'    => $comment->lastPage(),
            'record'      => GroupCommentResource::collection($comment),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

    }
}
