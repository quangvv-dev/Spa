<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Helpers\Functions;
use App\Http\Controllers\API\BaseApiController;
use App\Models\PackageWallet;
use App\Models\WalletHistory;
use App\Services\WalletService;
use Illuminate\Http\Request;

class OrdersController extends BaseApiController
{
    private $walletService;
    private static $UID;

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

        $value['order_id'] = $order->id;
        $value['amount'] = $order->order_price;
        $url = self::pushZALOPay($value);
        return $url;
//        return \redirect($url);
    }


    public function pushZALOPay($value)
    {
        $app_id = 2554;
        $key1 = 'sdngKKJmqEMzvh5QQcdD2A9XBSKUNaYn';
        $key2 = 'trMrHtvjo6myautxDUiAcYsVtaeQ8nhf';
        $postInput = [
            'amount'       => $value['amount'],
            'app_id'       => $app_id,
            'app_time'     => floor(microtime(true) * 1000),
            'app_trans_id' => date("ymd") . "_" . $value['order_id'] . "_" . getTimestamp(),
            'app_user'     => 'demo',
            'bankcode'     => "*",
            'currency'     => '',
            'description'  => 'Demo - Thanh toán đơn hàng', #220609_13626996
            'callback_url' => 'http://spa.yez.vn/vnpay',
            'embed_data'   => \GuzzleHttp\json_encode(['merchantinfo' => 'embeddata123', 'bankgroup' => 'ATM']),
            'item'         => \GuzzleHttp\json_encode([]),
            'key1'         => $key1,
            'key2'         => $key2,
            'more_param'   => "currency=VND&phone=0925226173",
        ];
        $dataHash = self::createOrderMacData($postInput);
        $mac = self::compute($dataHash, $key1);
        $postInput['mac'] = $mac;
        $params = "";
        foreach ($postInput as $k => $item) {
            if (!empty($params)) {
                $params = $params . '&' . $k . '=' . $item;
            } else {
                $params = $k . '=' . $item;
            }
        }
        $apiURL = 'https://sb-openapi.zalopay.vn/v2/create';
        $client = new \GuzzleHttp\Client();
        $request = $client->post($apiURL, [
            'Content-Type' => [
                'application/x-www-form-urlencoded',
                'application/json',
                'application/xml',
            ],
            'form_params'  => $postInput,
        ]);
        $response = \GuzzleHttp\json_decode($request->getBody()->read(1024));
        return redirect($response->order_url);

    }

    public function callbackZALOPay(Request $request)
    {
        dd($request->all());
        $key2 = 'trMrHtvjo6myautxDUiAcYsVtaeQ8nhf';
        $params = json_decode($request->data);
        $reqmac = self::redirect($params,$key2);
        if ($reqmac == $params['mac']) {
            // callback hợp lệ
        } else {
            // callback không hợp lệ
        }
    }

    static function newCreateOrderData(Array $params)
    {
        $app_id = '2554';
        $embeddata = [];

        if (array_key_exists("embeddata", $params)) {
            $embeddata = $params["embeddata"];
        }

        $order = [
            "appid"       => $app_id,
            "apptime"     => getTimeStamp(),
            "apptransid"  => self::GenTransID(),
            "appuser"     => array_key_exists("appuser", $params) ? $params["appuser"] : "demo",
            "item"        => \GuzzleHttp\json_encode(array_key_exists("item", $params) ? $params["item"] : []),
            "embeddata"   => \GuzzleHttp\json_encode($embeddata),
            "bankcode"    => array_key_exists("bankcode", $params) ? $params["bankcode"] : "zalopayapp",
            "description" => array_key_exists("description", $params) ? $params['description'] : "",
            "amount"      => $params['amount'],
        ];

        return $order;
    }

    static function compute(string $params, string $key1 = "9phuAOYhan4urywHTh0ndEXiV3pKHr5Q")
    {
        return hash_hmac("sha256", $params, $key1);
    }

    private static function createOrderMacData(Array $order)
    {
        return $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . $order["amount"]
            . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
    }

    static function createOrder(Array $order)
    {
        return self::compute(self::createOrderMacData($order));
    }

    static function redirect(Array $params, $key2 = "trMrHtvjo6myautxDUiAcYsVtaeQ8nhf")
    {
        return self::compute($params['appid'] . "|" . $params['apptransid'] . "|" . $params['pmcid'] . "|" . $params['bankcode']
            . "|" . $params['amount'] . "|" . $params['discountamount'] . "|" . $params["status"], $key2);
    }


    static function genTransID()
    {
        $app_id = '2554';
        return date("ymd") . "_" . $app_id . "_" . getTimestamp();
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
        $vnp_TmnCode = config('app.VNP_TMN_CODE'); //Mã website tại VNPAY LOCAL
        $vnp_HashSecret = config('app.VNP_HASH_SECRET'); //Chuỗi bí mật LOCAL
        $vnp_Url = config('app.VNP_URL');
        $vnp_ReturnUrl = config('app.VNP_RETURN_URL');
//        $vnp_TmnCode = 'RNQ6Y222'; //Mã website tại VNPAY spa.yez.vn
//        $vnp_HashSecret = 'XQCALQXEAECFMLOGVOJWYMIVHQJIRPUK'; //Chuỗi bí mật spa.yez.vn
////        $vnp_TmnCode = '55AG666V'; //Mã website tại VNPAY thamy
////        $vnp_HashSecret = 'SCDYTYKYBGRJORBGOUGFINIMMGPBRBMU'; //Chuỗi bí mật thammy
//        $vnp_Url = 'http://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
//        $vnp_ReturnUrl = 'http://spa.yez.vn/vnpay/';
////        $vnp_ReturnUrl = 'https://thammyroyal.adamtech.vn/vnpay/';

        $vnp_TxnRef = $data['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $data['order_desc'];
        $vnp_OrderType = $data['order_type'];
        $vnp_Amount = $data['amount'] * 100;
        $vnp_Locale = $data['language'];
        $vnp_BankCode = $data['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = [
            "vnp_Version"    => "2.1.0",
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
