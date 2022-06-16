<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\CustomerResource;
use App\Models\Customer;
use App\Models\HistoryWalletCtv;
use Illuminate\Http\Request;

class WalletsController extends BaseApiController
{

    public function __construct()
    {
        //coding
    }

    /**
     * Danh sách lịch hẹn
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
            ->where('customer_id', $customer->id)->orderByDesc('id')->paginate($records);
        $data = [
            'data' => $history->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'customer_id' => $item->customer_id,
                    'price' => $item->price,
                    'type' => $item->type,
                    'created_at' => date('d-m-Y H:s', strtotime($item->created_at)),
                ];
            })->toArray(),
            'currentPage' => $history->currentPage(),
            'lastPage' => $history->lastPage(),
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
                return $this->responseApi(ResponseStatusCode::OK, 'Chuyển tiền thành công', new CustomerResource($customers));
            }
        } else {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, "Không tìm thấy khách hàng");
        }
    }

}
