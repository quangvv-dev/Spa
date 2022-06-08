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
        try {
            if (count($inputData)) {
//                $vnp_HashSecret = config('app.VNP_HASH_SECRET'); //Chuỗi bí mật
                $vnp_HashSecret = 'SCDYTYKYBGRJORBGOUGFINIMMGPBRBMU'; //Chuỗi bí mật

                $value['vnp_SecureHash'] = $inputData['vnp_SecureHash'];
                unset($inputData['vnp_SecureHashType']);
                unset($inputData['vnp_SecureHash']);
                ksort($inputData);
                $i = 0;
                $hashData = "";
                foreach ($inputData as $key => $item) {
                    if ($i == 1) {
                        $hashData = $hashData . '&' . $key . "=" . $item;
                    } else {
                        $hashData = $hashData . $key . "=" . $item;
                        $i = 1;
                    }
                }
                $value['vnpTranId'] = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
                $value['vnp_BankCode'] = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
                $value['secureHash'] = hash('sha256', $vnp_HashSecret . $hashData);
                $orderId = $inputData['vnp_TxnRef'];
                $order = WalletHistory::find($orderId);
                if ($order->gross_revenue < $order->order_price) {
                    $returnData = self::checkSumDataAndUpdateOrder($value, $inputData, $order);
                    if ($returnData['RspCode'] != '00') {
                    }
                }
            }
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        if (isset($order)) {
            $historyOrder = PaymentWallet::where('order_wallet_id', $order->id)->latest()->first();
            $customer = Customer::find($order->customer_id);
            session(['info-temp' => $customer]);
        } else {
            $customer = null;
        }

        return view('walet.payment', compact( 'order', 'historyOrder'));
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
