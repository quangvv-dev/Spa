<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Helpers\Functions;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Resources\AppCustomers\PromotionResource;
use App\Models\Order;
use App\Models\PackageWallet;
use App\Models\Promotion;
use App\Models\WalletHistory;
use App\Services\WalletService;
use Illuminate\Http\Request;

class OrdersController extends BaseApiController
{
    private $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function getPackage()
    {
        $packages = PackageWallet::select('id', 'order_price', 'price')->get();
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $packages);
    }

    /**
     * Danh sách lịch hẹn
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeWallet(Request $request)
    {
        $package = PackageWallet::findOrFail($request->package_id);
        $customer = $request->jwtUser;
        $input = [
            'package_id'  => $package->id,
            'customer_id' => $customer->id,
            'user_id'     => $customer->id,
            'price'       => $package->price,
            'order_price' => $package->order_price,
            'branch_id'   => $customer->branch_id ?: 1,
        ];
        $wallet = $this->walletService->create($input);
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $wallet);
    }

    public function createOrderVNPay(Request $request)
    {
        $order = WalletHistory::find($request->pay_id);// đơn nạp ví

        $value['order_type'] = 'billpayment';
        $value['order_id'] = $order->id;
        $value['amount'] = $order->order_price;
        $value['order_desc'] = 'Thanh toan nap vi';
        $value['bank_code'] = null;
        $value['language'] = 'vn';
        $url = self::pushVNPAY($value);
        return \redirect($url);
    }

    /**
     * Đẩy đơn hàng lên VNPAY
     *
     * @param $data
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function pushVNPAY($data)
    {
//        $vnp_TmnCode = config('app.VNP_TMN_CODE'); //Mã website tại VNPAY LOCAL
//        $vnp_HashSecret = config('app.VNP_HASH_SECRET'); //Chuỗi bí mật LOCAL
//        $vnp_Url = config('app.VNP_URL');
//        $vnp_ReturnUrl = config('app.VNP_RETURN_URL');
        $vnp_TmnCode = '55AG666V'; //Mã website tại VNPAY LOCAL
        $vnp_HashSecret = 'SCDYTYKYBGRJORBGOUGFINIMMGPBRBMU'; //Chuỗi bí mật LOCAL
        $vnp_Url = 'http://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_ReturnUrl = 'https://thammyroyal.adamtech.vn/vnpay';

        $vnp_TxnRef = $data['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $data['order_desc'];
        $vnp_OrderType = $data['order_type'];
        $vnp_Amount = $data['amount'] * 100;
        $vnp_Locale = $data['language'];
        $vnp_BankCode = $data['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = [
            "vnp_Version"    => "2.0.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => $vnp_Locale,
            "vnp_OrderInfo"  => $vnp_OrderInfo,
            "vnp_OrderType"  => $vnp_OrderType,
            "vnp_ReturnUrl"  => $vnp_ReturnUrl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            "vnp_Merchant"   => 'DEMO',
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        $vnp_Url = Functions::hasReturnUrlVNPAY($inputData, $vnp_Url, $vnp_HashSecret);
        return $vnp_Url;
    }
}
