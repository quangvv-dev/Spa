<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\NotificationConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Models\NotificationCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends BaseApiController
{

    public function __construct()
    {
        //coding
    }

    /**
     * Danh sách thông báo
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $customer = $request->jwtUser;
        $records = isset($request->records) ? $request->records : StatusCode::PAGINATE_10;
        $history = NotificationCustomer::select('id', 'customer_id', 'title', 'data', 'type', 'status', 'created_at')
            ->where('customer_id', $customer->id)->whereIn('status', [NotificationConstant::UNREAD, NotificationConstant::READ])
            ->orderByDesc('id')->paginate($records);
        $data = [
            'data' => $history->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'customer_id' => $item->customer_id,
                    'title' => $item->title,
                    'type' => $item->type,
                    'data' => json_decode($item->data),
                    'status' => $item->status,
                    'created_at' => date('d-m-Y H:s', strtotime($item->created_at)),
                ];
            })->toArray(),
            'currentPage' => $history->currentPage(),
            'lastPage' => $history->lastPage(),
        ];

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
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
        $customer = $request->jwtUser;
        $docs = NotificationCustomer::select('id')->where('customer_id', $customer->id)
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
        $docs = NotificationCustomer::find($id);
        if (isset($docs) && $docs) {
            $docs->status = NotificationConstant::READ;
            $docs->save();
            $data = [
                'id' => $docs->id,
                'customer_id' => $docs->customer_id,
                'title' => $docs->title,
                'type' => $docs->type,
                'data' => json_decode($docs->data),
                'status' => $docs->status,
                'created_at' => date('d-m-Y H:s', strtotime($docs->created_at)),
            ];
            return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);

        }
    }

}
