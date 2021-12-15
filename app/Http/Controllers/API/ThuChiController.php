<?php

namespace App\Http\Controllers\API;

use App\Constants\NotificationConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Resources\ThuChiResource;
use App\Http\Resources\NotificationResource;
use App\Models\DanhMucThuChi;
use App\Models\Notification;
use App\Models\ThuChi;
use App\User;
use Illuminate\Support\Facades\Validator;
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
            $admin = $user->department_id == 1 && $user->role == 1 ? true : false;
            $quan_ly = $user->department_id == 1 && $user->role != 1 ? true : false;

            if ($request->pay_id) {
                $search['pay_id'] = $request->pay_id;
            }

            if (!$admin) {
                if ($quan_ly) {
                    $search['duyet_id'] = $user->id;
                } else {
                    $search['thuc_hien_id'] = $user->id;
                }
            } else {
                $search = $request->except('creator_id', 'censor_id', 'category_id');
                $search['thuc_hien_id']         = @$request->creator_id;
                $search['duyet_id']             = @$request->censor_id;
                $search['danh_muc_thu_chi_id']  = @$request->category_id;
            }
            $docs = ThuChi::search($search)->orderByDesc('id');
            $data['sumPrice'] = $docs->sum('so_tien');
            $data['sumCount'] = $docs->count();
            $docs = $docs->paginate(StatusCode::PAGINATE_20);
            $doc = ThuChiResource::collection($docs);
        }
        if ($request->pay_id) {
            $docs = ThuChi::where('id', $request->pay_id)->first();
            $doc = isset($docs) ? new ThuChiResource($docs) : [];
        }

        $data['records'] = $doc;

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * list người tạo và người duyệt
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listUserThuChi()
    {
        $creator = User::select('id', 'full_name')->where('department_id', 5)->get();//lễ tân
        $centor = User::select('id', 'full_name')->where('department_id', 1)->get();//ban giám đốc
        $data['creator'] = $creator;
        $data['centor'] = $centor;
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

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
        $result = fcmSendCloudMessage([$request->devices_token], "💸💸💸 Bạn có yêu cầu duyệt chi", 'Chạm để xem', 'notification', ['pay_id' => $request->pay_id]);
        return $this->responseApi(ResponseStatusCode::OK, $result);

    }

}
