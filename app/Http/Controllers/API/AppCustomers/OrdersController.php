<?php

namespace App\Http\Controllers\API\AppCustomers;

use App\Constants\ResponseStatusCode;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Http\Controllers\API\BaseApiController;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PackageWallet;
use App\Models\PaymentHistory;
use App\Models\PaymentWallet;
use App\Models\WalletHistory;
use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

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
        $packages = PackageWallet::select('id', 'order_price', 'price')->orderByDesc('order_price')->get();
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

    public function historyChangeWallet(Request $request)
    {
        $customer = $request->jwtUser;
        $arrWallets = WalletHistory::select('id')->where('customer_id', $customer->id)->pluck('id')->toArray();
        $wallets = PaymentWallet::select('price', 'payment_date')->whereIn('order_wallet_id',
            $arrWallets)->get()->map(function ($qr) {
            $qr->type = 1;
            return $qr;
        })->toArray();

        $orders = Order::select('id')->where('member_id', $customer->id)->pluck('id')->toArray();
        $payment = PaymentHistory::select('price', 'payment_date')->whereIn('order_id', $orders)->where('payment_type', 3)
            ->get()->map(function ($qr) {
            $qr->type = 2;
            return $qr;
        })->toArray();
        $data = array_merge($wallets, $payment);
        $page = !empty($request->page) ? $request->page : 1;
        $datas = Functions::paginationArray($page, $data, 1);
        $datas = [
            'data'        => $datas,
            'currentPage' => $page,
            'lastPage'    => (int)round(count($datas) / 1),
        ];
        $datas['data'] = $datas;
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $datas);
    }

    /**
     * Bao nhiêu để thăng hạng
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function rankingWallet(Request $request)
    {
        $customer = $request->jwtUser;
        $total = Functions::sumOrder($customer->id);
        $platinum = setting('platinum') ?: 0;
        if ($total < $platinum) {
            $gross = $platinum - $total;
            $param['title'] = 'Chi tiêu' . number_format($gross) . 'đ nữa để thăng hạng';
        } else {
            $param['title'] = 'Khách hàng đã đạt hạng cao nhất';
        }
        return $this->responseApi(ResponseStatusCode::OK, 'SUCCESS', $param);
    }

    /**
     * Tạo đơn bắn lên ZALOPAY
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createOrderVNPay(Request $request)
    {
        $order = WalletHistory::find($request->pay_id);// đơn nạp ví
        if (empty($order)) {
            return $this->responseApi(ResponseStatusCode::BAD_REQUEST, 'Không tìm thấy đơn nạp ví');
        }
        if ($order->order_price <= $order->gross_revenue) {
            return $this->responseApi(ResponseStatusCode::OK, 'Đơn nạp ví đã được thanh toán trước đó');
        }
        $value['order_id'] = $order->id;
        $value['amount'] = $order->order_price;
        if (!empty($request->payment_type)) {
            $value['bankcode'] = "*";
            $value['embed_data'] = \GuzzleHttp\json_encode(['merchantinfo' => 'embeddata123', 'bankgroup' => 'CC']);
        } else {
            $value['bankcode'] = "*";
            $value['embed_data'] = \GuzzleHttp\json_encode(['merchantinfo' => 'embeddata123', 'bankgroup' => 'ATM']);
        }
        $url = self::pushZALOPay($value);
        return redirect($url);

    }

    /**
     * Push value lên ZALOPAY
     *
     * @param $value
     *
     * @return mixed
     */
    public function pushZALOPay($value)
    {
        $app_id = config('app.ZALOPAY_APP_ID');
        $key1 = config('app.ZALOPAY_KEY1');
        $key2 = config('app.ZALOPAY_KEY2');
        $postInput = [
            'amount'       => $value['amount'],
            'app_id'       => $app_id,
            'app_time'     => floor(microtime(true) * 1000),
            'app_trans_id' => date("ymd") . "_" . $value['order_id'] . "_" . time(),
            'app_user'     => 'demo',
            'bankcode'     => $value['bankcode'],
            'currency'     => '',
            'description'  => 'Demo - Thanh toán đơn hàng', #220609_13626996
            'callback_url' => request()->getSchemeAndHttpHost() . '/api/callback-zalo-pay',
            'redirect_url' => request()->getSchemeAndHttpHost() . '/vnpay',
            'embed_data'   => $value['embed_data'],
            'item'         => \GuzzleHttp\json_encode([]),
            'key1'         => $key1,
            'key2'         => $key2,
            'more_param'   => "currency=VND&phone=0925226173",
        ];
        $dataHash = self::createOrderMacData($postInput);
        $mac = self::compute($dataHash, $key1);
        $postInput['mac'] = $mac;
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
        return $response->order_url;
    }

    public function callbackZALOPay(Request $request)
    {
        $data = $request->all();
        $key2 = config('app.ZALOPAY_KEY2');
        try {
            $params = (array)json_decode($data['data']);
            $result = self::verifyCallback($data, $key2);
            $pay_id = explode('_', $params['app_trans_id'])[1];
            if ($result['returncode'] === 1) {
                # Giao dịch thành công, tiền hành xử lý đơn hàng
                $order = WalletHistory::find($pay_id);// đơn nạp ví
                $order->gross_revenue = $order->gross_revenue + $params['amount'];
                $order->app_trans_id = $params['app_trans_id'];
                $order->save();
                $type = PaymentWallet::$typePayment[$params['channel']] ?: '';
                $input = [
                    'order_wallet_id' => $order->id,
                    'price'           => $params['amount'],
                    'description'     => 'TT:ZaloPay -- app_trans_id:' . $params['app_trans_id'] . ' --' . $type,
                    'payment_type'    => 5,//thanh toán zaloPay
                    'payment_date'    => Carbon::now()->format('Y-m-d'),
                    'branch_id'       => $order->branch_id,
                    'app_trans_id'    => $params['app_trans_id'],
                ];
                PaymentWallet::create($input);
                $customer = Customer::find($order->customer_id);
                $customer->wallet = $customer->wallet + $params['amount'];
                $customer->save();
                return response()->json([
                    'returncode' => $result["returncode"],
                    'messages'   => $result["returnmessage"],
                ]);
            } else {
                return response()->json([
                    "returncode"    => 0, # ZaloPay Server sẽ callback lại tối đa 3 lần
                    "returnmessage" => "exception",
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
                "returncode"    => 0, # ZaloPay Server sẽ callback lại tối đa 3 lần
                "returnmessage" => $exception,
            ]);
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

    static function redirectCallBack(Array $params, $key2 = "trMrHtvjo6myautxDUiAcYsVtaeQ8nhf")
    {
        return self::compute($params['appid'] . "|" . $params['apptransid'] . "|" . $params['pmcid'] . "|" . $params['bankcode']
            . "|" . $params['amount'] . "|" . $params['discountamount'] . "|" . $params["status"], $key2);
    }

    static function redirectCallBackV2(Array $params, $key2 = "trMrHtvjo6myautxDUiAcYsVtaeQ8nhf")
    {
        return self::compute($params['app_id'] . "|" . $params['app_trans_id'] . "|" . $params['app_time'] . "|" . $params['app_user']
            . "|" . $params['amount'] . "|" . $params['embed_data'] . "|" . $params["item"] . "|" . $params["zp_trans_id"] . "|" . $params["server_time"] . "|" . $params["channel"] . "|" . $params["merchant_user_id"] . "|" . $params["zp_user_id"] . "|" . $params["user_fee_amount"] . "|" . $params["discount_amount"],
            $key2);
    }


    static function genTransID()
    {
        $app_id = '2554';
//        return date("ymd") . "_" . $app_id . "_" . getTimestamp();
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

    /**
     * Kiểm callback có hợp lệ hay không
     *
     * @param Array $params ["data" => string, "mac" => string]
     *
     * @return Array ["returncode" => int, "returnmessage" => string]
     */
    static function verifyCallback(Array $params, $key2)
    {
        $data = $params["data"];
        $requestMac = $params["mac"];

        $result = [];
        $mac = self::compute($data, $key2);

        if ($mac != $requestMac) {
            $result['returncode'] = -1;
            $result['returnmessage'] = 'mac not equal';
        } else {
            $result['returncode'] = 1;
            $result['returnmessage'] = 'success';
        }
        return $result;
    }
}
