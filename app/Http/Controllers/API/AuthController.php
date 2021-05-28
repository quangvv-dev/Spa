<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Models\Branch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class AuthController extends BaseApiController
{
    /**
     * Login APP
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $info = User::where('phone', $request->phone)->first();
        if (empty($info)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Không tồn tại tài khoản');
        } else {
            if (password_verify($request->password, $info->password) != true) {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Sai mật khẩu');
            } else {
                if ($info->active == StatusCode::ON) {
                    $payload = $info->toArray();
                    $payload['time'] = strtotime(Date::now());
//                    $payload['exp'] = time() + $this->time_jwt_exp; //thời gian chết của token
                    $data = [
                        'token' => jwtencode($payload),
                        'info' => $info,
                    ];

                    return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
                } else {
                    return $this->responseApi(ResponseStatusCode::UNAUTHORIZED, 'Tài khoản bị khoá');
                }
            }
        }

    }

    /**
     * Danh sách chi nhánh
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function branch()
    {
        $branchs = Branch::select('id', 'name')->get();
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $branchs);
    }
}
