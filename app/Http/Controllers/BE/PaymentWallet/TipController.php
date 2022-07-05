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
        $tips = Tip::orderByDesc('id')->paginate(StatusCode::PAGINATE_10);
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
        $tip = Tip::find($id);
        $request->merge([
            'price'=> str_replace(',', '', $request->price),
        ]);
        if (isset($tip) && $tip) {
            $tip->update($request->all());
        }
        if ($request->ajax()) {
            return 1;
        }
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

        Tip::find($id)->delete();
        if ($request->ajax()) {
            $request->session()->flash('error', 'Xoá thủ thuật thành công!');
        }
    }
}
