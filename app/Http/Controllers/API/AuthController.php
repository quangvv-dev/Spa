<?php

namespace App\Http\Controllers\API;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Resources\UserResource;
use App\Models\Branch;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseApiController
{
    /**
     * Login APP
     *
     * @param Request $request
     *
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
                        'info'  => $info,
                    ];

                    return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
                } else {
                    return $this->responseApi(ResponseStatusCode::UNAUTHORIZED, 'Tài khoản bị khoá');
                }
            }
        }

    }

    /**
     * Change password
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {

        $user = User::find($request->jwtUser->id);

        $messages = [
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min'      => 'Mật khẩu phải lớn hơn 6 ký tự!',
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
                'code'    => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->all(),
            ]);
        }

        try {
            if (Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => Hash::make(request('new_password')),
                ]);
                return response()->json([
                    'code'    => ResponseStatusCode::OK,
                    'message' => 'Thay đổi mật khẩu thành công',
                ]);
            } else {
                return response()->json([
                    'code'    => ResponseStatusCode::BAD_REQUEST,
                    'message' => 'Mật khẩu cũ không đúng',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code'    => ResponseStatusCode::INTERNAL_SERVER_ERROR,
                'message' => __('system.server_error'),
            ]);
        }
    }


    /**
     * Basic register
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $required = [
            'password'  => ['required', 'string'],
            'full_name' => ['required', 'string'],
            'phone'     => ['unique:users', 'regex:/(0)[0-9]{9}/'],
        ];
        $messages = [
            'full_name.required' => 'Chưa nhập tên',
            'phone.unique'       => 'Số điện thoại trùng',
            'password.required'  => 'Chưa nhập mật khẩu',
        ];

        $validator = Validator::make($request->all(), $required, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code'    => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }

        $check_phone = User::where('phone', $request->input('phone'))->first();
        if (isset($check_phone)) {
            return response()->json([
                'code'    => ResponseStatusCode::PHONE_ALREADY_EXIST,
                'message' => "Số điện thoại đã tồn tại !!!",
            ]);
        } else {
            $user = User::create([
                'full_name'     => $request->input('full_name'),
                'phone'         => $request->input('phone'),
                'password'      => bcrypt($request->input('password')),
                'active'        => StatusCode::ON,
                'role'          => 11,
                'department_id' => 5,
                'branch_id'     => 1,
                'gender'        => 1,
            ]);
        }

        if ($user) {
            $payload = $user->toArray();
            $payload['time'] = strtotime(Date::now());
            $data = [
                'token' => jwtencode($payload),
                'info'  => $user,
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        }

        return response()->json([
            'code'    => ResponseStatusCode::NOT_FOUND,
            'message' => 'Đăng ký không thành công !!!',
        ]);
    }

    /**
     * Change Profile
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile(Request $request)
    {
        $user = User::find($request->jwtUser->id);

        try {
            if ($user) {
                if ($user->password != '' || $user->password != null) {
                    $user->check_password = true;
                } else {
                    $user->check_password = false;
                }

                return response()->json([
                    'code'    => ResponseStatusCode::OK,
                    'message' => __('auth.user_view_success'),
                    'data'    => [
                        'customer' => new UserResource($user),
                    ],
                ]);
            } else {
                return response()->json([
                    'code'    => ResponseStatusCode::PHONE_ALREADY_EXIST,
                    'message' => __('auth.not_view_user_success'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code'    => ResponseStatusCode::INTERNAL_SERVER_ERROR,
                'message' => __('system.server_error'),
            ]);
        }
    }

    /**
     * Change Profile
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeProfile(Request $request)
    {
        $user = User::find($request->jwtUser->id);
//        $regexName = regexName();
        $required = [
            'full_name' => "required|min:2|max:255",
            'phone'     => "required|unique:users,phone,$user->id|regex:/(0)[0-9]{9}/",
        ];

        $messages = [
            'phone.required'     => 'Vui lòng nhập số điện thoại',
            'phone.unique'       => __('auth.phone_exists'),
            'full_name.required' => 'Nhập tên người dùng',
        ];

        $validator = Validator::make($request->all(), $required, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code'    => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }

        $user_check_phone = User::where('phone', $request->phone)->where('id', '!=', $user->id)->first();

        if (isset($user_check_phone)) {
            return response()->json([
                'code'    => ResponseStatusCode::PHONE_EXIST,
                'message' => __('auth.phone_exists'),
            ]);
        }


        $user->update([
            'full_name' => request('full_name'),
            //            'email' => request('email'),
            'phone'     => request('phone'),
            'gender'    => request('gender'),
            //            'avatar' => request('avatar'),
        ]);

        try {
            if ($user) {
                return response()->json([
                    'code'    => ResponseStatusCode::OK,
                    'message' => __('auth.edit_user_success'),
                    'data'    => new UserResource($user),
                ]);
            } else {
                return response()->json([
                    'code'    => ResponseStatusCode::USER_NOT_EXIST,
                    'message' => __('auth.not_edit_user_success'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code'    => ResponseStatusCode::INTERNAL_SERVER_ERROR,
                'message' => __('system.server_error'),
            ]);
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

    public function uri()
    {
        return response()->json([
            'code' => ResponseStatusCode::OK,
            'messages' => 'SUCCESS',
//            'data' => true,
            'data' => false,
        ]);
    }
}
