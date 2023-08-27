<?php

namespace App\Http\Controllers\API;

use App\Constants\DepartmentConstant;
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
            'lastPage'    => $comment->lastPage(),
            'record'      => GroupCommentResource::collection($comment),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function store(Request $request, Customer $customer)
    {
        $request->merge([
            'user_id'     => $request->jwtUser->id,
            'customer_id' => $customer->id,
        ]);
        $data = GroupComment::create($request->all());
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', new GroupCommentResource($data));
    }

    /**
     * @param Request      $request
     * @param GroupComment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, GroupComment $comment)
    {
        if ($request->jwtUser->id == $comment->user_id || $request->jwtUser->department_id == DepartmentConstant::ADMIN) {
            $comment->delete();
            return $this->responseApi(ResponseStatusCode::OK, 'Xóa thành công trao đổi');
        } else {
            return $this->responseApi(ResponseStatusCode::UNAUTHORIZED, 'Bạn không có quyền để xóa');
        }
    }
}
