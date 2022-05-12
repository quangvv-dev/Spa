<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseApiController
{

    public function __construct()
    {
        // coding
    }


    /**
     * Login APP
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $info = Customer::where('phone', $request->phone)->first();
        if (empty($info)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'SĐT chưa được đăng ký');
        } else {
            if (password_verify($request->password, $info->password) != true) {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Sai mật khẩu');
            } else {
                $payload = $info->toArray();
                $payload['time'] = strtotime(Date::now());
//                    $payload['exp'] = time() + $this->time_jwt_exp; //thời gian chết của token
                $data = [
                    'token' => jwtencode($payload),
                    'info' => new CustomerResource($info),
                ];
                return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
            }
        }
    }

    /**
     * Check số điện thoại tồn tại
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPhoneExist(Request $request)
    {
        $validate = ['phone' => "required"];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $user = Customer::where('phone', $request->input('phone'))->first();
        if (!$user) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Không tồn tại tài khoản');
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');
    }


    /**
     * Quên mật khẩu
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $validate = [
            'phone' => "required",
            'password' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }

        $user = Customer::where('phone', $request->input('phone'))->first();

        if (!$user) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Không tồn tại tài khoản');
        }

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');

    }

    /**
     * Đổi mật khẩu
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $user = $request->jwtUser;

        $messages = [
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải lớn hơn 6 ký tự!',
        ];

        if ($user->password != '' || $user->password != null) {
            $validator = Validator::make($request->only('new_password', 'old_password'), [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
            ], $messages);
        } else {
            $validator = Validator::make($request->only('new_password'), [
                'new_password' => 'required|min:6',
            ], $messages);
        }

        if ($validator->fails()) {
            return response()->json([
                'code' => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        }

        if ($user->password == '' || $user->password == null) {
            $save = Customer::find($user->id);
            if (isset($save) && $save) {
                $save->password = Hash::make(request('new_password'));
                $save->save();
            }
            return $this->responseApi(ResponseStatusCode::OK, 'Cập nhật mật khẩu thành công !');
        }

        try {
            if (Hash::check($request->old_password, $user->password)) {
                if (isset($save) && $save) {
                    $save->password = Hash::make(request('new_password'));
                    $save->save();
                }
                return $this->responseApi(ResponseStatusCode::OK, 'Cập nhật mật khẩu thành công !');

            } else {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Nhập sai mật khẩu cũ!');
            }
        } catch (\Exception $e) {
            return $this->responseApi(ResponseStatusCode::INTERNAL_SERVER_ERROR, 'Lỗi hệ thống');
        }
    }

    public function register()
    {

    }
}
