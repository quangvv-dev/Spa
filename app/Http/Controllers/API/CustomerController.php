<?php

namespace App\Http\Controllers\API;

use App\Constants\DepartmentConstant;
use App\Constants\NotificationConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Http\Resources\ThuChiResource;
use App\Http\Resources\NotificationResource;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\DanhMucThuChi;
use App\Models\Notification;
use App\Models\NotificationCustomer;
use App\Models\Status;
use App\Models\ThuChi;
use App\Services\CustomerService;
use App\User;
use App\Http\Controllers\API\AppCustomers\AuthController;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CustomerController extends BaseApiController
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Danh sách album
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->merge(['type' => 'full_data']);
        $input = $request->all();
        if (!empty($input['search'])) {
            $input['page'] = 1;
        }
        if (isset($input['location_id'])) {
            $group_branch = Branch::where('location_id', $input['location_id'])->pluck('id')->toArray();
            $input['group_branch'] = $group_branch;
        }
        if (isset($input['search']) && $input['search'] && is_numeric($input['search'])) {
            unset($input['branch_id']);
        }
        $customers = Customer::searchApi($input);

        $customers = $customers->take(StatusCode::PAGINATE_1000)->orderByDesc('id')->get();
        if (isset($input['limit'])) {
            $customers = Functions::customPaginate($customers, $input['page'], $input['limit']);
        } else {
            $customers = Functions::customPaginate($customers, $input['page']);
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', CustomerResource::collection($customers));
    }

    /**
     * list người tạo và người duyệt
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validate = [
            'phone' => "required",
            'full_name' => "required",
            'gender' => "required",
            'telesales_id' => "required",
            'status_id' => "required",
            'source_id' => "required",
            'group_id' => "required",
            'branch_id' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $customer = $request->jwtUser;

        $request->merge([
            'fb_name' => $request->full_name,
            'full_name' => str_replace("'", "", $request->full_name),
            'type' => 'full_data',
        ]);

        $input = $request->except(['group_id']);
        $input['mkt_id'] = empty($input['mkt_id']) ? $customer->id : $input['mkt_id'];
        $input['telesales_id'] = empty($input['telesales_id']) ? $customer->id : $input['mkt_id'];
        $input['wallet'] = 0;
        $input['wallet_ctv'] = 0;
        $input['post_id'] = 0;
        $input['status_id'] = empty($input['status_id']) ? Functions::getStatusWithCode('moi') : $input['status_id'];
        $customer = $this->customerService->createApi($input);

        $category = Category::whereIn('id', $request->group_id)->get();
        AuthController::createCustomerGroup($category, $customer->id, $input['branch_id']);

        $payload = $customer->toArray();
        $payload['time'] = strtotime(Date::now());
//                    $payload['exp'] = time() + $this->time_jwt_exp; //thời gian chết của token
        $data = [
            'token' => jwtencode($payload),
            'info' => new CustomerResource($customer),
        ];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', (array)$data);

    }

    /**
     * cập nhật thu chi
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $docs = ThuChi::find($id);
        if (isset($docs) && $docs) {
            $docs->status = UserConstant::ACTIVE;
            $docs->save();
        }
        $docs = new ThuChiResource($docs);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);

    }

    /**
     * cập nhật thu chi
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $docs = ThuChi::find($id);
        if (isset($docs) && $docs) {
            $docs->status = UserConstant::ACTIVE;
            $docs->save();
        }
        $docs = new ThuChiResource($docs);

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);

    }

    /**
     * Danh sách danh mục thu chi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategory()
    {
        $docs = DanhMucThuChi::select('id', 'name')->get();
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);

    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotification(Request $request)
    {
        $user = User::find($request->jwtUser->id);
        $docs = Notification::select('id', 'title', 'data', 'type', 'status', 'created_at')->where('user_id', $user->id)
            ->where('status', '<>', NotificationConstant::HIDDEN)->orderByDesc('created_at')->paginate(StatusCode::PAGINATE_10);
        $docs = NotificationResource::collection($docs);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);
    }

    /**
     * Đếm số lượng thông báo chưa đọc
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countNotification(Request $request)
    {
        $user = User::find($request->jwtUser->id);
        $docs = Notification::select('id')->where('user_id', $user->id)
            ->where('status', NotificationConstant::UNREAD)->count();
        $doc = ['unread' => $docs];
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $doc);
    }

    /**
     *
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function readNotification($id)
    {
        $docs = Notification::find($id);
        if (isset($docs) && $docs) {
            $docs->status = NotificationConstant::READ;
            $docs->save();
        }
        $docs = new NotificationResource($docs);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $docs);
    }

    /**
     * Update device token firebase
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDevicesToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'devices_token' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::where('id', $request->customer_id)->first();
        if (isset($user) && $user) {
            $user->devices_token = $request->devices_token;
            $user->save();
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS');
        } else {
            return $this->responseApi(ResponseStatusCode::NOT_FOUND, 'NOT FOUND USER');
        }

    }

    /**
     * Test firebase
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function testSendFirebase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'devices_token' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => ResponseStatusCode::UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first(),
            ]);
        }
        fcmSendCloudMessage([$request->devices_token], "🗓 Bạn có lịch hẹn lúc 15:00 hôm nay !!!", 'Chạm để xem', 'notification',
            ['type' => NotificationConstant::LICH_HEN, 'schedule_id' => 9477]);
//        $result = NotificationCustomer::create([
//            'customer_id'   => 93811,
//            'title'     => '🏵️🏵️🏵️ TRẺ HÓA LÁ VÀNG 24K, liên tục gây sốt',
//            'data'      => \GuzzleHttp\json_encode(['type' => NotificationConstant::TIN_QC,'content'=>$text]),
//            'type'      => NotificationConstant::TIN_QC,
//            'status'    => 1,
//        ]);
        return $this->responseApi(ResponseStatusCode::OK);

    }

}
