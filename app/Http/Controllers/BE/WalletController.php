<?php

namespace App\Http\Controllers\BE;

use App\Helpers\Functions;
use App\Models\Customer;
use App\Models\PackageWallet;
use App\Models\PaymentWallet;
use App\Models\WalletHistory;
use App\Services\WalletService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class WalletController extends Controller
{
    private $walletService;

    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(WalletService $walletService)
    {

        $this->walletService = $walletService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = PackageWallet::findOrFail($request->package_id);
        $customer = Customer::findOrFail($request->customer_id);
        $input = [
            'package_id'  => $package->id,
            'customer_id' => $customer->id,
            'user_id'     => Auth::user()->id,
            'price'       => $package->price,
            'order_price' => $package->order_price,
            'branch_id'   => $customer->branch_id,
        ];
        $wallet = $this->walletService->create($input);
        return redirect('/wallet/' . $wallet->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->walletService->find($id);
        $payment = PaymentWallet::where('order_wallet_id', $order->id)->get();
        return view('payment_wallet.index', compact('order', 'payment'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $walet = WalletHistory::find($id);
        if (!empty($walet)) {
            $customer = Customer::find($walet->customer_id);
            if ($walet->gross_revenue < $walet->order_price) {
                $customer->wallet = ($customer->wallet - $walet->gross_revenue) > 0 ? $customer->wallet - $walet->gross_revenue : 0;
            } elseif ($walet->gross_revenue >= $walet->order_price) {
                $customer->wallet = ($customer->wallet - $walet->price) > 0 ? $customer->wallet - $walet->price : 0;
            }
            $customer->save();
            PaymentWallet::where('order_wallet_id', $walet->id)->delete();
            $walet->delete();
            $request->session()->flash('error', 'Xóa thành công danh mục!');
        } else {
            $request->session()->flash('error', 'Không thể xóa vì lịch sử ví!');
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexVNPAY(Request $request)
    {
        $inputData = $request->all();
        $app_id = config('app.ZALOPAY_APP_ID');
        $key1 = config('app.ZALOPAY_KEY1');
        $key2 = config('app.ZALOPAY_KEY2');

        $isValidRedirect = self::verifyRedirect($inputData, $key2);
        if ($isValidRedirect) {
            $apptransid = $inputData["apptransid"];
            # Kiểm tra xem đã nhận được callback chưa
            $order = WalletHistory::where('app_trans_id', $apptransid)->first();// đơn nạp ví
            if (empty($order)) {
                # Nếu chưa nhận được callback thì gọi API truy vấn trạng thái đơn hàng
                $dataRaw = $inputData['appid'] . "|" . $inputData['apptransid'] . "|" . $key1;
                $mac1 = self::compute($dataRaw, $key1);
                $params = [
                    "appid"      => $app_id,
                    "apptransid" => $apptransid,
                    "mac"        => $mac1,
                ];
                $client = new \GuzzleHttp\Client();
                $request = $client->post('https://sandbox.zalopay.com.vn/v001/tpe/getstatusbyapptransid', [
                    'Content-Type' => [
                        'application/x-www-form-urlencoded',
                        'application/json',
                        'application/xml',
                    ],
                    'form_params'  => $params,
                ]);
                $response = \GuzzleHttp\json_decode($request->getBody()->read(1024));
                if ($response->returncode === 1) {
                    $pay_id = explode('_', $apptransid)[1];
                    # Giao dịch thành công, tiền hành xử lý đơn hàng
                    $order = WalletHistory::find($pay_id);// đơn nạp ví
                    $order->gross_revenue = (int)$order->gross_revenue+(int)$response->amount;
                    $order->app_trans_id = $apptransid;
                    $order->save();
                    $input = [
                        'order_wallet_id' => $order->id,
                        'price'           => $order->gross_revenue,
                        'description'     => 'TT:ZaloPay -- app_trans_id:' . $apptransid . ' -- NG.HANG ' . $response->bankcode,
                        'payment_type'    => 5,//thanh toán zaloPay
                        'payment_date'    => Carbon::now()->format('Y-m-d'),
                        'branch_id'       => $order->branch_id,
                        'app_trans_id'    => $apptransid,
                    ];
                    $payment = PaymentWallet::create($input);
                    $customer = Customer::find($order->customer_id);
                    $customer->wallet = $customer->wallet + $response->amount;
                    $customer->save();
                    $currentWallet = $customer->wallet;
                }
            } else {
                $payment = PaymentWallet::where('app_trans_id',$apptransid)->first();
                $customer = Customer::find($order->customer_id);
                $currentWallet = $customer->wallet;
            }
        }

        return view('wallet.payment', compact('order', 'currentWallet','payment'));
    }

    /**
     * Kiểm callback có hợp lệ hay không
     *
     * @param Array $data - là query string mà zalopay truyền vào redirect link ($_GET)
     *
     * @return bool
     *  - true: hợp lệ
     *  - false: không hợp lệ
     */
    public function verifyRedirect(Array $data, $key2)
    {
        $reqChecksum = $data["checksum"];
        $checksum = self::redirectCallBack($data, $key2);

        return $reqChecksum === $checksum;
    }

    /**
     * toàn vẹn dữ liệu return
     *
     * @param array  $params
     * @param string $key2
     *
     * @return string
     */
    public function redirectCallBack(Array $params, $key2 = "trMrHtvjo6myautxDUiAcYsVtaeQ8nhf")
    {
        return self::compute($params['appid'] . "|" . $params['apptransid'] . "|" . $params['pmcid'] . "|" . $params['bankcode']
            . "|" . $params['amount'] . "|" . $params['discountamount'] . "|" . $params["status"], $key2);
    }


    public function compute(string $params, string $key1 = "9phuAOYhan4urywHTh0ndEXiV3pKHr5Q")
    {
        return hash_hmac("sha256", $params, $key1);
    }

    /**
     * @param $value
     * @param $inputData
     * @param $order
     *
     * @return array|mixed
     */
    public function checkSumDataAndUpdateOrder($value, $inputData, $order)
    {
        $returnData = [];
        try {
            //Kiểm tra checksum của dữ liệu
            if ($value['secureHash'] == $value['vnp_SecureHash']) {
                if ($order != null) {
                    if ($order->gross_revenue < $order->order_price) {
                        if ($inputData['vnp_ResponseCode'] == '00') {


                            $data['order_wallet_id'] = $order->id;
                            $data['price'] = $order->total_price;
                            $data['payment_type'] = 4;
                            $data['branch_id'] = $order->branch_id;
                            $data['payment_date'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                            $data['description'] = 'VNPAY Ngân Hàng: ' . $value['vnp_BankCode'] . ' - TranID: ' . $value['vnpTranId'];

                            PaymentWallet::create($data);

                            $order->gross_revenue = $order->gross_revenue + ($inputData['vnp_Amount'] / 100) > 0 ? $order->gross_revenue + ($inputData['vnp_Amount'] / 100) : 0;
                            $order->save();
                            $order->customer->wallet = $order->customer->wallet + ($inputData['vnp_Amount'] / 100) > 0 ? $order->customer->wallet + ($inputData['vnp_Amount'] / 100) : 0;
                            $order->customer->save();

                            //notification
//                            $message = 'Giao dịch thanh toán thành công';
//                            $title = 'Thông báo thanh toán 💱';
//                            $tag = $order->user_id;
//                            $data_noti = [
//                                'type' => NotificationConstant::TYPE_THANH_TOAN_SUCCESS
//                            ];
//                            SendNotification::dispatch($message,$title,$tag,$data_noti)->delay(now()->addMinute(1));
//                            Functions::saveNotify($tag,$title,$message,$data_noti,NotificationConstant::TYPE_THANH_TOAN_SUCCESS);

                        }
                        $returnData = Functions::returnMessage('00');
                    } else {
                        $returnData = Functions::returnMessage('02');
                        $message = 'Giao dịch thanh toán không thành công';
                        $title = 'Thông báo thanh toán 💱';
//                        $tag = $order->user_id;
//                        $data_noti = [
//                            'type' => NotificationConstant::TYPE_THANH_TOAN_ERROR,
//                        ];
//                        SendNotification::dispatch($message, $title, $tag, $data_noti)->delay(now()->addMinute(1));
//                        Functions::saveNotify($tag, $title, $message, $data_noti,
//                            NotificationConstant::TYPE_THANH_TOAN_ERROR);
                    }
                } else {
                    $message = 'Giao dịch thanh toán không thành công';
                    $title = 'Thông báo thanh toán 💱';
//                    $tag = $order->user_id;
//                    $data_noti = [
//                        'type' => NotificationConstant::TYPE_THANH_TOAN_ERROR,
//                    ];
//                    SendNotification::dispatch($message, $title, $tag, $data_noti)->delay(now()->addMinute(1));
//                    Functions::saveNotify($tag, $title, $message, $data_noti,
//                        NotificationConstant::TYPE_THANH_TOAN_ERROR);
                    $returnData = Functions::returnMessage('01');
                }
            } else {
                $message = 'Giao dịch thanh toán không thành công';
                $title = 'Thông báo thanh toán 💱';
//                $tag = $order->user_id;
//                $data_noti = [
//                    'type' => NotificationConstant::TYPE_THANH_TOAN_ERROR,
//                ];
//                SendNotification::dispatch($message, $title, $tag, $data_noti)->delay(now()->addMinute(1));
//                Functions::saveNotify($tag, $title, $message, $data_noti, NotificationConstant::TYPE_THANH_TOAN_ERROR);
                $returnData = Functions::returnMessage('97');
            }
        } catch (Exception $e) {
            $message = 'Giao dịch thanh toán không thành công';
            $title = 'Thông báo thanh toán 💱';
//            $tag = $order->user_id;
//            $data_noti = [
//                'type' => NotificationConstant::TYPE_THANH_TOAN_ERROR,
//            ];
//            SendNotification::dispatch($message, $title, $tag, $data_noti)->delay(now()->addMinute(1));
//            Functions::saveNotify($tag, $title, $message, $data_noti, NotificationConstant::TYPE_THANH_TOAN_ERROR);
            $returnData = Functions::returnMessage('99');
        }
        return $returnData;
    }
}
