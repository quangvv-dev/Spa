<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Resources\ThuChiResource;
use App\Models\ThuChi;
use App\User;
use Illuminate\Http\Request;

class ThuChiController extends BaseApiController
{

    /**
     * Danh sách album
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = User::find($request->jwtUser->id);
        if ($user) {

        }
        $search = $request->all();
        $quan_ly = $user->department_id == 1 && $user->role != 1 ? true : false;

        if ($quan_ly) {
            $search['duyet_id'] = $user->id;
        } else {
            $search['thuc_hien_id'] = $user->id;
        }
        $docs = ThuChi::search($search)->orderByDesc('id')->paginate(StatusCode::PAGINATE_20);
        $doc = ThuChiResource::collection($docs);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $doc);
    }

    public function update($id)
    {
        $docs = ThuChi::find($id);
        if (isset($docs) && $docs){
            $docs->status = UserConstant::ACTIVE;
            $docs->save();
        }
        $docs = new ThuChiResource($docs);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);

    }

}
