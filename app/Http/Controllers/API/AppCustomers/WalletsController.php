<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\NotificationConstant;
use App\Constants\OrderConstant;
use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Models\Customer;
use App\Models\HistoryWalletCtv;
use App\Models\NotificationCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WalletsController extends BaseApiController
{

    public function __construct()
    {
        //coding
    }

    /**
     * Danh sách lịch sử ví CTV
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $customer = $request->jwtUser;
        $records = isset($request->records) ? $request->records : StatusCode::PAGINATE_10;
        $history = HistoryWalletCtv::select('id', 'customer_id', 'price', 'type', 'created_at')
            ->where('customer_id', $customer->id)->when(isset($request->status) && $request->status,
                function ($qr) use ($request) {
                    $qr->where('status', $request->status);
                })->orderByDesc('id')->paginate($records);
        $data = [
            'data'        => $history->transform(function ($item) {
                return [
                    'id'          => $item->id,
                    'customer_id' => $item->customer_id,
                    'price'       => $item->price,
                    'type'        => $item->type,
                    'created_at'  => date('d-m-Y H:s', strtotime($item->created_at)),
                ];
            })->toArray(),
            'currentPage' => $history->currentPage(),
            'lastPage'    => $history->lastPage(),
        ];

        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $data);
    }

    /**
     * Chuyển tiền từ ví ctv sang ví thường
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiveMoney(Request $request)
    {
        $customer = $request->jwtUser;
        $validate = [
            'price' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }
        $customers = Customer::find($customer->id);
        if (isset($customers) && $customers) {
            if ($request->price > $customers->wallet_ctv) {
                return $this->responseApi(ResponseStatusCode::BAD_REQUEST, "Số tiền vượt quá số dư");
            } else {
                $customers->wallet = (int)$customers->wallet + (int)$request->price;
                $customers->wallet_ctv = (int)$customers->wallet_ctv - (int)$request->price;
                $customers->save();
                HistoryWalletCtv::create(
                    [
                        'customer_id' => $customers->id,
                        'price'       => $request->price,
                        'type'        => OrderConstant::WALLET_TYPE_RECEIVE,
                        'created_at'  => Carbon::now(),
                    ]
                );
                return $this->responseApi(ResponseStatusCode::OK, 'Chuyển tiền thành công',
                    new CustomerResource($customers));
            }
        } else {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, "Không tìm thấy khách hàng");
        }
    }

    /**
     * Action rút tiền
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdraw(Request $request)
    {
        $validate = [
            'price'       => "required",
            'description' => "required",
        ];
        $this->validator($request, $validate);
        if (!empty($this->error)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, $this->error);
        }elseif ($request->price < 100000){
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, "Số tiền rút tối thiểu 100,000 VNĐ");
        }
        $customer = $request->jwtUser;

        $history = HistoryWalletCtv::create(
            [
                'customer_id' => $customer->id,
                'price'       => $request->price,
                'type'        => OrderConstant::WALLET_TYPE_MONEY,
                'created_at'  => Carbon::now(),
                'description' => $request->description,
            ]
        );
        $data = [
            'id'          => $history->id,
            'customer_id' => $history->customer_id,
            'price'       => $history->price,
            'type'        => $history->type,
            'description' => $history->description,
            'created_at'  => date('d-m-Y H:s', strtotime($history->created_at)),
        ];
        if (!empty($customer->devices_token)) {
            $devices_token = [$customer->devices_token];
            fcmSendCloudMessage($devices_token, '💰💰💰 Yêu cầu rút tiền thành công', 'Chạm để xem', 'notification',
                ['type' => NotificationConstant::RUT_TIEN, 'history_id' => $history->id]);
        }
        NotificationCustomer::create([
            'customer_id' => $customer->id,
            'title'       => '💰💰💰 Yêu cầu rút tiền thành công',
            'data'        => \GuzzleHttp\json_encode(['type' => NotificationConstant::RUT_TIEN, 'history_id' => $history->id]),
            'type'        => NotificationConstant::RUT_TIEN,
            'status'      => 1,
        ]);
        return $this->responseApi(ResponseStatusCode::OK, "Yêu cầu rút tiền thành công", $data);
    }

    /**
     * Ẩn hiện ví đẩy chợ
     *
     * @return \Illuminate\Http\JsonResponse
     * false là hiển thị ví; true là ẩn
     */
    public function hiddenWallet()
    {
        return $this->responseApi(ResponseStatusCode::OK, "SUCCESS", false);
    }
}
