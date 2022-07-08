<?php

namespace App\Http\Controllers\BE\PaymentWallet;

use App\Constants\StatusCode;
use App\Models\Tip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

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
            'price' => str_replace(',', '', $request->price),
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

    public function exportData()
    {
        $data = Tip::get();
        Excel::create('DS thủ thuật (' . Carbon::now()->format('d-m-Y') . ')', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:C1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->freezeFirstRow();
                $sheet->row(1, [
                    'Thủ thuật',
                    'Giá công',
                    'Cụm áp dụng',
                ]);

                $i = 1;
                if ($data) {
                    foreach ($data as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$ex->name,
                            @number_format($ex->price),
                            @$ex->location_id==1?'Cụm Miền Bắc':($ex->location_id==3)?'Cụm miền nam':"Tất cả chi nhánh",
                        ]);
                    }
                }
            });
        })->export('xlsx');

    }
}
