<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
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
                    'token' => jwtencode($payload),
                    'info' => new CustomerResource($info),
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
        $otp = Otp::where('phone', $request->phone)->where('otp', $request->otp)->first();
        if (empty($otp)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Mã OTP chưa đúng !');
        }

        $info = Customer::where('phone', $request->phone)->first();
        if (empty($info)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'SĐT chưa được đăng ký');
        } else {
            $payload = $info->toArray();
            $payload['time'] = strtotime(Date::now());
            $data = [
                'token' => jwtencode($payload),
                'info' => new CustomerResource($info),
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

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
     *
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
                    'phone' => $customer->gioithieu->phone,
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
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');
        } else {
            return $this->responseApi(ResponseStatusCode::NOT_FOUND, 'Token không hợp lệ');
        }

    }

    /**
     * Lấy OTP
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOtp(Request $request)
    {
        $validate = ['phone' => "required"];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $data = Otp::where('phone', $request->phone)->first();
        $otp = Functions::generateRandomNumber();
        $text = 'Ma xac minh ROYAL: ' . (string)$otp . '. Co hieu luc trong 15 phut. KHONG chia se ma nay voi nguoi khac, ke ca nhan vien ROYAL';

        if (empty($data)) {
            Otp::create([
                'phone' => $request->phone,
                'otp' => $otp,
                'count' => 1,
            ]);
        } else {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $now = strtotime($now);
            $to = strtotime($data->updated_at);
            $distance = round(($now - $to) / 60);
            if ($data->count < 6) {
                if ((int)$distance < 15) {
                    return $this->responseApi(ResponseStatusCode::OK, 'OTP chưa hết hiệu lực 15 phút. Chưa thể gửi thêm !');

                } else {
                    $data->otp = $otp;
                    $data->count = $data->count + 1;
                    $data->save();
                }
            } else {
                return $this->responseApi(ResponseStatusCode::OK, 'Mỗi ngày chỉ được yêu cầu OTP không quá 5 lần !');
            }
        }
        $err = Functions::sendSmsV3($request->phone, @$text);
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
                'code' => ResponseStatusCode::UNPROCESSABLE_ENTITY,
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
            'phone' => "required",
//            'category_id' => "required",
            'branch_id' => "required",
            'password' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $input = $request->except('category_id');
        $input['mkt_id'] = 0;
        $input['wallet'] = 0;
        $input['post_id'] = 0;
        $input['status_id'] = Functions::getStatusWithCode('moi');
        $input['password'] = Hash::make($input['password']);

        $customer = $this->customerService->create($input);
        $this->update_code($customer);
//        if (count($request->category_id)) {
        $category = Category::whereIn('name', 'like', '%DV Khác%')->get();
        self::createCustomerGroup($category, $customer->id, $input['branch_id']);
//        }
        $payload = $customer->toArray();
        $payload['time'] = strtotime(Date::now());
//                    $payload['exp'] = time() + $this->time_jwt_exp; //thời gian chết của token
        $data = [
            'token' => jwtencode($payload),
            'info' => new CustomerResource($customer),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    public function update_code($customer)
    {
        $customer_id = $customer->id < 10 ? '0' . $customer->id : $customer->id;
        $code = 'KH' . $customer_id;
        $customer->update(['account_code' => $code]);
    }

    protected function createCustomerGroup($category, $customer_id, $branch_id)
    {
        if (count($category)) {
            foreach ($category as $item) {
                CustomerGroup::create([
                    'customer_id' => $customer_id,
                    'category_id' => $item->id,
                    'branch_id' => $branch_id,
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i'),
                ]);
            }
        }
    }
}
