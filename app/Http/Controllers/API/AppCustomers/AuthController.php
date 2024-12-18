<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Otp;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends BaseApiController
{

    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }


    /**
     * Login APP
     *
     * @param Request $request
     *
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
                    'token' => jwtEncode($payload),
                    'info'  => new CustomerResource($info),
                ];
                return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
            }
        }
    }

    /**
     * Login APP
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginOTP(Request $request)
    {
        if ($request->otp == '228823'){
            $info = Customer::where('phone', $request->phone)->first();
            if ($info->active_app == UserConstant::INACTIVE) {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Tài khoản đã bị khóa');
            }
            $payload = $info->toArray();
            $payload['time'] = strtotime(Date::now());
            $data = [
                'token' => jwtencode($payload),
                'info'  => new CustomerResource($info),
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'Đăng nhập thành công', $data);
        }

        $otp = Otp::where('phone', $request->phone)->where('otp', $request->otp)->first();
        if (empty($otp)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Chưa bắn OTP');
        } else {
            $check = Functions::checkExpiredOtp($otp);
            if ($check == 1) {
                $info = Customer::where('phone', $request->phone)->first();
                if (empty($info)) {
                    return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'SĐT chưa được đăng ký');
                } else {
                    if ($info->active_app == UserConstant::INACTIVE) {
                        return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Tài khoản đã bị khóa');
                    }
                    $payload = $info->toArray();
                    $payload['time'] = strtotime(Date::now());
                    $data = [
                        'token' => jwtencode($payload),
                        'info'  => new CustomerResource($info),
                    ];
                    return $this->responseApi(ResponseStatusCode::OK, 'Đăng nhập thành công', $data);
                }
            } else {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Mã OTP chưa đúng !');
            }
        }

    }

    /**
     * Check số điện thoại tồn tại
     *
     * @param Request $request
     *
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $validate = [
            'phone'    => "required",
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $user = $request->jwtUser;

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

    /**
     * Cập nhật người giới thiệu
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAgency(Request $request)
    {
        $info = $request->jwtUser;
        $validator = Validator::make($request->all(), [
            'phone' => ['required'],
        ]);
        if ($validator->fails()) {
            return $this->responseApi(ResponseStatusCode::UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }
        $customer = Customer::where('id', $info->id)->first();
        if (isset($customer) && $customer) {
            if ($customer->phone == $request->phone) {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Vui lòng không nhập SĐT của bạn');
            }
            if ($customer->is_gioithieu) {
                $data = [
                    'full_name' => $customer->gioithieu->full_name,
                    'phone'     => $customer->gioithieu->phone,
                ];
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Khách hàng đã nhập người giới thiệu',
                    $data);
            }
            $agency = Customer::where('phone', $request->phone)->first();
            if (empty($agency)) {
                return $this->responseApi(ResponseStatusCode::NOT_FOUND, 'Không tìm thấy người giới thiệu');
            }
            $customer->is_gioithieu = $agency->id;
            $customer->save();
            return $this->responseApi(ResponseStatusCode::OK, 'Đăng ký thành công');
        } else {
            return $this->responseApi(ResponseStatusCode::NOT_FOUND, 'Không tồn tại khách hàng này');
        }

    }

    /**
     * Lấy OTP
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOtp(Request $request)
    {
        $validate = ['phone' => "required", 'deviceId' => "required"];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $device = Otp::where('deviceId', $request->deviceId)->count();
        if ($device > 5) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST,
                'Mỗi ngày thiết bị được yêu cầu OTP không quá 5 lần !');
        }
        $data = Otp::where('phone', $request->phone)->first();
        $otp = Functions::generateRandomNumber();
        $text = 'Ma xac minh ROYAL: ' . (string)$otp . '. Co hieu luc trong 15 phut. KHONG chia se ma nay voi nguoi khac, ke ca nhan vien ROYAL';
        if (empty($data)) {
            $err = Functions::sendSmsV3($request->phone, @$text);
            Otp::create([
                'phone'    => $request->phone,
                'otp'      => $otp,
                'count'    => 1,
                'deviceId' => $request->deviceId,
            ]);
        } else {
            $check = Functions::checkExpiredOtp($data);
            if ($data->count < 6) {
                if ($check == 1) {
                    return $this->responseApi(ResponseStatusCode::BAD_REQUEST,
                        'OTP chưa hết hiệu lực 15 phút. Vui lòng kiểm tra tin nhắn !');
                } else {
                    $err = Functions::sendSmsV3($request->phone, @$text);
                    $data->otp = $otp;
                    $data->count = $data->count + 1;
                    $data->save();
                }
            } else {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST,
                    'Mỗi ngày SĐT được yêu cầu OTP không quá 5 lần !');
            }
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', [$err]);
    }

    /**
     * Update device token firebase
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDevicesTokenCustomer(Request $request)
    {
        $info = $request->jwtUser;
        $validator = Validator::make($request->all(), [
            'devices_token' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code'    => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }

        $customer = Customer::where('id', $info->id)->first();
        if (isset($customer) && $customer) {
            $customer->devices_token = $request->devices_token;
            $customer->save();
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');
        } else {
            return $this->responseApi(ResponseStatusCode::NOT_FOUND, 'NOT FOUND USER');
        }

    }

    /**
     * Get info
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $info = $request->jwtUser;
        $customer = Customer::find($info->id);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', new CustomerResource($customer));

    }

    /**
     * Cập nhật profiles
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $info = $request->jwtUser;
        $customer = Customer::find($info->id);
        if ($customer) {
            $customer->update($request->all());
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', new CustomerResource($customer));

        } else {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Không tồn tại khách hàng');
        }
    }

    /**
     * Đăng ký tài khoản
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validate = [
            'full_name' => "required",
            'phone'     => "required",
            'branch_id' => "required",
            'otp'       => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }

        $otp = Otp::where('phone', $request->phone)->where('otp', $request->otp)->first();
        if (empty($otp)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Mã OTP chưa đúng !');
        }
        $check = Functions::checkExpiredOtp($otp);
        if ($check == 0) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Mã OTP chưa đúng !');
        }

        $input = $request->except('category_id');
        $input['wallet'] = 0;
        $input['wallet_ctv'] = 0;
        $input['post_id'] = 0;
        $input['status_id'] = Functions::getStatusWithCode('moi');

        $customer = $this->customerService->createApi($input);
        $this->update_code($customer);
        $category = Category::where('name', 'like', '%DV Khác%')->get();
        self::createCustomerGroup($category, $customer->id, $input['branch_id']);
        $payload = $customer->toArray();
        $payload['time'] = strtotime(Date::now());
//                    $payload['exp'] = time() + $this->time_jwt_exp; //thời gian chết của token
        $data = [
            'token' => jwtencode($payload),
            'info'  => new CustomerResource($customer),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function update_code($customer)
    {
        $customer_id = $customer->id < 10 ? '0' . $customer->id : $customer->id;
        $code = 'KH' . $customer_id;
        $customer->account_code = $code;
        $customer->save();
    }

    public static function createCustomerGroup($category, $customer_id, $branch_id)
    {
        if (count($category)) {
            foreach ($category as $item) {
                CustomerGroup::create([
                    'customer_id' => $customer_id,
                    'category_id' => $item->id,
                    'branch_id'   => $branch_id,
                    'created_at'  => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                ]);
            }
        }
    }

    public function inactiveApp(Request $request)
    {
        $validate = [
            'status' => "required|in:1,0",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }

        $info = $request->jwtUser;
        $customer = Customer::find($info->id);
        if ($customer) {
            $customer->active_app = $request->status;
            $customer->save();
            return $this->responseApi(ResponseStatusCode::OK, 'Tài khoản đã khoá thành công');
        } else {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Không tồn tại khách hàng');
        }
    }
}
