<?php

namespace App\Http\Controllers\API;

use App\Constants\DepartmentConstant;
use App\Constants\MenuConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Resources\UserResource;
use App\Models\Branch;
use App\Models\Source;
use App\Models\Status;
use App\Models\Team;
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
//                if (!in_array($info->department_id,
//                    [DepartmentConstant::ADMIN, DepartmentConstant::MARKETING, DepartmentConstant::CARE_PAGE])) {
//                    return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Tài khoản không có quyền');
//                }
                if ($info->active == StatusCode::ON) {
                    $payload = $info->toArray();
                    $payload['time'] = strtotime(Date::now());
//                    $payload['exp'] = time() + $this->time_jwt_exp; //thời gian chết của token
                    $data = [
                        'token' => jwtEncode($payload),
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
     * Khóa tài khoản
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function blockUser(Request $request)
    {
        $user = User::find($request->jwtUser->id);
        try {
            if ($user && $user->active == StatusCode::ON) {
                $user->active = StatusCode::OFF;
                $user->save();

                return response()->json([
                    'code' => ResponseStatusCode::OK,
                    'message' => 'Xóa tài khoản thành công !!',
                    'data' => [],
                ]);
            } else {
                return response()->json([
                    'code' => ResponseStatusCode::NOT_FOUND,
                    'message' => 'Không tồn tại tài khoản',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => ResponseStatusCode::INTERNAL_SERVER_ERROR,
                'message' => __('system.server_error'),
            ]);
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

        try {
            if (Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => Hash::make(request('new_password')),
                ]);
                return response()->json([
                    'code' => ResponseStatusCode::OK,
                    'message' => 'Thay đổi mật khẩu thành công',
                ]);
            } else {
                return response()->json([
                    'code' => ResponseStatusCode::BAD_REQUEST,
                    'message' => 'Mật khẩu cũ không đúng',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => ResponseStatusCode::INTERNAL_SERVER_ERROR,
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
            'password' => ['required', 'string'],
            'full_name' => ['required', 'string'],
            'phone' => ['unique:users', 'regex:/(0)[0-9]{9}/'],
        ];
        $messages = [
            'full_name.required' => 'Chưa nhập tên',
            'phone.unique' => 'Số điện thoại trùng',
            'password.required' => 'Chưa nhập mật khẩu',
        ];

        $validator = Validator::make($request->all(), $required, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code' => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }

        $check_phone = User::where('phone', $request->input('phone'))->first();
        if (isset($check_phone)) {
            return response()->json([
                'code' => ResponseStatusCode::PHONE_ALREADY_EXIST,
                'message' => "Số điện thoại đã tồn tại !!!",
            ]);
        } else {
            $user = User::create([
                'full_name' => $request->input('full_name'),
                'phone' => $request->input('phone'),
                'password' => bcrypt($request->input('password')),
                'active' => StatusCode::ON,
                'role' => 11,
                'department_id' => 5,
                'branch_id' => 1,
                'gender' => 1,
            ]);
        }

        if ($user) {
            $payload = $user->toArray();
            $payload['time'] = strtotime(Date::now());
            $data = [
                'token' => jwtencode($payload),
                'info' => $user,
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
        }

        return response()->json([
            'code' => ResponseStatusCode::NOT_FOUND,
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
                    'code' => ResponseStatusCode::OK,
                    'message' => __('auth.user_view_success'),
                    'data' => [
                        'customer' => new UserResource($user),
                    ],
                ]);
            } else {
                return response()->json([
                    'code' => ResponseStatusCode::PHONE_ALREADY_EXIST,
                    'message' => __('auth.not_view_user_success'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => ResponseStatusCode::INTERNAL_SERVER_ERROR,
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
            'phone' => "required|unique:users,phone,$user->id|regex:/(0)[0-9]{9}/",
        ];

        $messages = [
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.unique' => __('auth.phone_exists'),
            'full_name.required' => 'Nhập tên người dùng',
        ];

        $validator = Validator::make($request->all(), $required, $messages);
        if ($validator->fails()) {
            return response()->json([
                'code' => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }

        $user_check_phone = User::where('phone', $request->phone)->where('id', '!=', $user->id)->first();

        if (isset($user_check_phone)) {
            return response()->json([
                'code' => ResponseStatusCode::BAD_REQUEST,
                'message' => __('auth.phone_exists'),
            ]);
        }


        $user->update([
            'full_name' => request('full_name'),
            //            'email' => request('email'),
            'phone' => request('phone'),
            'gender' => request('gender'),
            //            'avatar' => request('avatar'),
        ]);

        try {
            if ($user) {
                return response()->json([
                    'code' => ResponseStatusCode::OK,
                    'message' => __('auth.edit_user_success'),
                    'data' => new UserResource($user),
                ]);
            } else {
                return response()->json([
                    'code' => ResponseStatusCode::BAD_REQUEST,
                    'message' => __('auth.not_edit_user_success'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => ResponseStatusCode::INTERNAL_SERVER_ERROR,
                'message' => __('system.server_error'),
            ]);
        }
    }

    /**
     * Danh sách chi nhánh
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function branch(Request $request)
    {
        $user = User::find($request->jwtUser->id);
        if (!empty($user->branch_id)) {
            $branchs = Branch::select('id', 'name')->where('id', $user->branch_id)->get();
        } else {
            $branchs = Branch::select('id', 'name')->get();
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $branchs);
    }

    public function testSendSMS(Request $request)
    {
        $response = self::SendSMS($request->phone, $request->contents);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $response);

    }


    public function SendSMS($phone, $sms_text, $send_after = '')
    {
        $data = [
            'to' => $phone,
            'from' => "ROYAL SPA",
            'message' => $sms_text,
            'scheduled' => $send_after,//15-01-2019 16:05
            'requestId' => "",
            'useUnicode' => 0,//sử dụng có dấu hay k dấu
            'type' => 1, // CSKH hay QC
        ];
        $data = json_encode((object)$data);
        $base_url = 'http://api.brandsms.vn:8018/api/SMSBrandname/SendSMS';
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c24iOiJyb3lhbHNwYSIsInNpZCI6ImFmZTIxOWQ4LTdhM2UtNDA5MS05NjBmLThmZjViNGI4NzRhMiIsIm9idCI6IiIsIm9iaiI6IiIsIm5iZiI6MTU4OTM1NDE4MCwiZXhwIjoxNTg5MzU3NzgwLCJpYXQiOjE1ODkzNTQxODB9.Hx8r30IR1nqAkOClihx0n9upfvgOg1f-E3MwNEwWT-0';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "token: $token",
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    public function menuPermission()
    {
        $data = [
            [
                'menu_code' => MenuConstant::THONG_KE,
                'department' => [DepartmentConstant::ADMIN],
                'name_menu' => 'THỐNG KÊ',
            ],
            [
                'menu_code' => MenuConstant::DOANH_THU,
                'department' => [DepartmentConstant::ADMIN],
                'name_menu' => 'DOANH THU',
            ],
            [
                'menu_code' => MenuConstant::DOANH_THU_THEO_NHOM,
                'department' => [DepartmentConstant::ADMIN],
                'name_menu' => 'DOANH THU THEO NHÓM',
            ],
            [
                'menu_code' => MenuConstant::THONG_KE_NGUON,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::MARKETING],
                'name_menu' => 'THỐNG KÊ NGUỒN',
            ],
//            [
//                'menu_code'  => MenuConstant::BAO_CAO_MKT,
//                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::MARKETING],// tạm ẩn
//                'name_menu'  => 'BÁO CÁO MARKETING',
//            ],
//            [
//                'menu_code'  => MenuConstant::BAO_CAO_SALE,
//                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::TELESALES],// tạm ẩn
//                'name_menu'  => 'BÁO CÁO TELESALES',
//            ],
            [
                'menu_code' => MenuConstant::THONG_KE_SP_KHO,
                'department' => [DepartmentConstant::ADMIN],
                'name_menu' => 'THỐNG KÊ SẢN PHẨM KHO',
            ],
//            [
//                'menu_code'  => MenuConstant::THONG_KE_LICH_HEN,
//                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::TELESALES,DepartmentConstant::MARKETING],
//                'name_menu'  => 'THỐNG KÊ LỊCH HẸN',
//            ],
            [
                'menu_code' => MenuConstant::XEP_HANG,
                'department' => [
                    DepartmentConstant::ADMIN,
                    DepartmentConstant::TELESALES,
                    DepartmentConstant::MARKETING,
                    DepartmentConstant::WAITER,
                    DepartmentConstant::TU_VAN_VIEN,
                    DepartmentConstant::TECHNICIANS,
                    DepartmentConstant::CSKH,
                ],
                'name_menu' => 'XẾP HẠNG',
            ],
            [
                'menu_code' => MenuConstant::XEP_HANG_SALE,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::TELESALES],
                'name_menu' => 'XẾP HẠNG TELESALES',
            ],
            [
                'menu_code' => MenuConstant::XEP_HANG_MKT,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::MARKETING],
                'name_menu' => 'XẾP HẠNG MARKETING',
            ],
            [
                'menu_code' => MenuConstant::XEP_HANG_CAREPAGE,
                'department' => [
                    DepartmentConstant::ADMIN,
                    DepartmentConstant::CARE_PAGE,
                    DepartmentConstant::MARKETING,
                ],
                'name_menu' => 'XẾP HẠNG CAREPAGE',
            ],
            [
                'menu_code' => MenuConstant::XEP_HANG_LETAN,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::WAITER],
                'name_menu' => 'XẾP HẠNG LỄ TÂN',
            ],
            [
                'menu_code' => MenuConstant::XEP_HANG_CSKH,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::CSKH],
                'name_menu' => 'XẾP HẠNG CSKH',
            ],
            [
                'menu_code' => MenuConstant::XEP_HANG_KTV,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::TECHNICIANS],
                'name_menu' => 'XẾP HẠNG KỸ THUÂT VIÊN',
            ],
            [
                'menu_code' => MenuConstant::XEP_HANG_TVV,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::TU_VAN_VIEN],
                'name_menu' => 'XẾP HẠNG TƯ VẤN VIÊN',
            ],
            [
                'menu_code' => MenuConstant::BAN_HANG,
                'department' => [
                    DepartmentConstant::ADMIN,
                    DepartmentConstant::TELESALES,
                    DepartmentConstant::MARKETING,
                ],
                'name_menu' => 'BÁN HÀNG',
            ],
            [
                'menu_code' => MenuConstant::QL_TONG_DAI,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::TELESALES],
                'name_menu' => 'QL TỔNG ĐÀI',
            ],
            [
                'menu_code' => MenuConstant::DS_DON_HANG,
                'department' => [
                    DepartmentConstant::ADMIN,
                    DepartmentConstant::TELESALES,
                    DepartmentConstant::MARKETING,
                ],
                'name_menu' => 'DS ĐƠN HÀNG',
            ],
            [
                'menu_code' => MenuConstant::CONG_VIEC_CSKH,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::TELESALES],
                'name_menu' => 'CÔNG VIỆC CSKH',
            ],
            [
                'menu_code' => MenuConstant::DANH_SACH_KH,
                'department' => [
                    DepartmentConstant::ADMIN,
                    DepartmentConstant::TELESALES,
                    DepartmentConstant::MARKETING,
                    DepartmentConstant::CARE_PAGE,
                    DepartmentConstant::WAITER,
                ],
                'name_menu' => 'DANH SÁCH KHÁCH HÀNG',
            ],
            [
                'menu_code' => MenuConstant::DANH_SACH_DUYET_CHI,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::KE_TOAN],
                'name_menu' => 'DANH SÁCH DUYỆT CHI',
            ],
            [
                'menu_code' => MenuConstant::NHAN_SU,
                'department' => [DepartmentConstant::ADMIN, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                'name_menu' => 'NHÂN SỰ',
            ],
            [
                'menu_code' => MenuConstant::BANG_LUONG,
                'department' => [DepartmentConstant::ADMIN, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                'name_menu' => 'BẢNG LƯƠNG',
            ],
            [
                'menu_code' => MenuConstant::CHAM_CONG,
                'department' => [DepartmentConstant::ADMIN, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                'name_menu' => 'CHẤM CÔNG',
            ],
            [
                'menu_code' => MenuConstant::DON_TU,
                'department' => [DepartmentConstant::ADMIN, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                'name_menu' => 'ĐƠN TỪ',
            ],
            [
                'menu_code' => MenuConstant::LICH_HEN,
                'department' => [DepartmentConstant::ADMIN, DepartmentConstant::TELESALES, DepartmentConstant::WAITER],
                'name_menu' => 'LỊCH HẸN',
            ],
            [
                'menu_code' => MenuConstant::ALBUM_KH,
                'department' => [
                    DepartmentConstant::ADMIN,
                    DepartmentConstant::TELESALES,
                    DepartmentConstant::WAITER,
                    DepartmentConstant::TECHNICIANS,
                ],
                'name_menu' => 'HỒ SƠ KHÁCH HÀNG',
            ],
        ];

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function source()
    {
        $data = Status::where('type', StatusCode::SOURCE_CUSTOMER)->select('id', 'name')->get();
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function teams(Request $request)
    {
        $auth = User::find($request->jwtUser->id);
        if (empty($request->department)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'required department field');
        }
        $teams = [];
        switch ($request->department){
            case 'sale':
                $department =  DepartmentConstant::TELESALES;
                break;
                case 'cskh':
                $department =  DepartmentConstant::CSKH;
                break;
                case 'carepage':
                $department =  DepartmentConstant::CARE_PAGE;
                break;
                default:
                $department = DepartmentConstant::MARKETING;
                break;
        }
        if ($auth->permission('filter.team')) {
            $teams = Team::select('id', 'name')->where('department_id', $department)->get();
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $teams);
    }
}
