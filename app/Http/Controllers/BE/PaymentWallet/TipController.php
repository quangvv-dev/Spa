<?php

namespace App\Http\Controllers\BE\PaymentWallet;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\PaymentWallet;
use App\Models\Tip;
use App\Models\WalletHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Services\WalletService;

class TipController extends Controller
{
    private $walletService;

    /**
     * PaymentWalletController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tips = Tip::orderByDesc('id')->get();
        if ($request->ajax()) {
            return view('tips.ajax', compact('tips'));
        }
        return view('tips.index', compact('tips'));

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
        Tip::create([
            'name' => 'Thủ thuật mới',
            'price' => 0,
        ]);

        return back()->with('status', 'Tạo thủ thuật thành công');
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
        return view('payment_wallet.index', compact('order'));

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
     * @param int $id
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
        $payment = PaymentWallet::find($id);
        if (!empty($payment) && isset($payment->order_wallet)) {
            $order = $payment->order_wallet;
            $customer = Customer::find($order->customer_id);

            if ($order->gross_revenue < $order->order_price) {
                $customer->wallet = ($customer->wallet - $payment->price) > 0 ? $customer->wallet - $payment->price : 0;
            } elseif ($order->gross_revenue >= $order->order_price) {
                $customer->wallet = $customer->wallet - $payment->price - ($order->price - $order->order_price);
                $customer->wallet = $customer->wallet > 0 ? $customer->wallet : 0;
            }
            $order->gross_revenue = ($order->gross_revenue - $payment->price) > 0 ? $order->gross_revenue - $payment->price : 0;
            $order->save();
            $customer->save();

            $payment->delete();
            $request->session()->flash('error', 'Xóa lịch sử thanh toán thành công!');
        } else {
            $request->session()->flash('error', 'Không tồn tại đơn nạp ví !');
        }
    }

    public function pdf($id)
    {
        $order = $this->walletService->find($id);
        $payment = PaymentWallet::where('order_wallet_id', $id)->latest()->first();
        return view('payment_wallet.order-pdf', compact('order', 'payment'));
    }
}
