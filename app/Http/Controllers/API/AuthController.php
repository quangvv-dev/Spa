<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class AuthController extends BaseApiController
{
    /**
     * Update Post
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $info = User::where('phone', $request->phone)->first();
        if (empty($info)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'user not found');
        } else {
            if (password_verify($request->password, $info->password) != true ) {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'pass failed or not permision');
            } else {
                if ($info->active == 1) {
                    $payload = $info->toArray();
                    $payload['time'] = strtotime(Date::now());
                    $data = [
                        'token' => jwtencode($payload),
                        'info' => $info,
                    ];

                    $acc            = $info;
                    $payload        = [];
                    $payload['iss'] = $request->fullUrl();
                    $payload['iat'] = time();
                    $payload['exp'] = time() + $this->time_jwt_exp;
                    $payload['sub'] = $acc->id;
                    $payload['id']  = $payload['sub'];
//                , 'user' => $acc
                    $data = ['token' => jwtencode($payload)];

//                    return jsonApiItem($data);


                    return $this->responseApi(ResponseStatusCode::OK, 'login success', $data);
                } else {
                    return $this->responseApi(ResponseStatusCode::UNAUTHORIZED, 'PERMISSION NOT FOUND');
                }


                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'BAD REQUEST');
            }
        }

    }
}
