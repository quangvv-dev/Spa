<?php

namespace App\Http\Controllers\BE;

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
            'package_id' => $package->id,
            'customer_id' => $customer->id,
            'user_id' => Auth::user()->id,
            'price' => $package->price,
            'order_price' => $package->order_price,
            'branch_id' => $customer->branch_id,
        ];
        $this->walletService->create($input);
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
        $walet = WalletHistory::find($id);
        if (!empty($walet)) {
            $customer = Customer::find($walet->customer_id);
            if ($walet->gross_revenue < $walet->order_price) {
                $customer->wallet = ($customer->wallet - $walet->gross_revenue) > 0 ? $customer->wallet - $walet->gross_revenue : 0;
            } elseif ($walet->gross_revenue >= $walet->order_price) {
                $customer->wallet = ($customer->wallet - $walet->price) > 0 ? $customer->wallet - $walet->price : 0;
            }
            $customer->save();
            $walet->delete();
            $request->session()->flash('error', 'Xóa thành công danh mục!');
        } else {
            $request->session()->flash('error', 'Không thể xóa vì lịch sử ví!');
        }
    }
}
