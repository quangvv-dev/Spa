<?php

namespace App\Http\Controllers\BE;

use App\Models\Customer;
use App\Models\PackageWallet;
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
        ];
        $this->walletService->create($input);
        $customer->wallet = $customer->wallet + $package->price;
        $customer->save();
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
    public function destroy($id)
    {
        //
    }
}
