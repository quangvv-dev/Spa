<?php

namespace App\Http\Controllers\BE\PaymentWallet;

use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\PaymentWallet;
use App\Models\WalletHistory;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Services\WalletService;

class PaymentWalletController extends Controller
{
    private $walletService;

    /**
     * PaymentWalletController constructor.
     */
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
        $branchs = Branch::search()->pluck('name', 'id');
        $letan = User::where('department_id', 5)->pluck('full_name', 'id');
        view()->share([
            'branchs' => $branchs,
            'letan' => $letan
        ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'ĐÃ THU TRONG KỲ ĐƠN NẠP';
        if (!$request->start_date) {
            Functions::addSearchDateFormat($request, 'd-m-Y');
        }
        $input = $request->all();
        $checkRole = checkRoleAlready();
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        }
        $datas = PaymentWallet::search($input);
        View::share([
            'allTotal' => $datas->sum('price'),
            'theRest' => $datas->order_wallet->sum('price') - $datas->sum('price'),
        ]);

        $datas = $datas->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('payment_wallet.ajax-payment', compact('datas'));
        }
        return view('payment_wallet.index-payment', compact('datas', 'title'));

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
        $order = WalletHistory::findOrFail($request->order_wallet_id);
        if (!empty($order)) {
            $input = [
                'order_wallet_id' => $order->id,
                'price' => $request->gross_revenue,
                'description' => $request->description,
                'payment_type' => $request->payment_type,
                'payment_date' => Functions::yearMonthDay($request->payment_date),
                'branch_id' => $order->branch_id,
            ];
            PaymentWallet::create($input);

            $order->gross_revenue = $order->gross_revenue + $request->gross_revenue;
            $order->save();
            $customer = Customer::find($order->customer_id);
            if ($order->gross_revenue < $order->order_price) {
                $customer->wallet = $customer->wallet + $request->gross_revenue;
            } elseif ($order->gross_revenue >= $order->order_price) {
                $customer->wallet = $customer->wallet + $request->gross_revenue + ($order->price - $order->order_price);
            }
            $customer->save();
        }

        return back()->with('status', 'Nạp tiền thành công');
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
        return view('payment_wallet.order-pdf', compact('order','payment'));
    }
}
