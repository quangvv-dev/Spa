<?php

namespace App\Http\Controllers\BE\Gift;

use App\Constants\OrderConstant;
use App\Constants\StatusCode;
use App\Models\Gift;
use App\Models\GroupComment;
use App\Models\HistoryDepot;
use App\Models\ProductDepot;
use App\Services\ProductHistoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    private $historyDepot;

    public function __construct(ProductHistoryService $historyDepot)
    {
        $this->historyDepot = $historyDepot;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $gifts = Gift::search($input)->orderByDesc('id')->paginate(StatusCode::PAGINATE_10);
        if ($request->ajax()) {
            return view('gifts.ajax', compact('gifts'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $param = $request->except('product', 'quantity');
        $param['branch_id'] = Auth::user()->branch_id ?: 0;
        if (count($request->quantity)) {
            foreach ($request->quantity as $key => $item) {
                $param['quantity'] = $item;
                $param['product_id'] = @$request->product[$key];
                Gift::create($param);

                $doc = ProductDepot::search($param)->first();
                if (isset($doc) && $doc) {
                    $doc->quantity = $doc->quantity - (int)$param['quantity'];
//                    $param['code_order'] = $param['order_id'];
                    unset($param['order_id'], $param['customer_id']);
                    $input = $param;
                    $input['status'] = OrderConstant::TANG_KHACH;
                    $input['note'] = "LỄ TÂN XUẤT TẶNG KHÁCH";
                    $this->historyDepot->create($input);
                    $doc->save();
                }
            }
        }
        return back()->with('success', 'Tạo quà KH thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gift = Gift::find($id);
        if (isset($gift) && $gift) {
            GroupComment::create([
                'customer_id' => $gift->customer_id,
                'user_id' => 1,
                'messages' => 'Tin hệ thống : ' . Auth::user()->full_name . ' đã hủy quà tặng ' . @$gift->product->name . ' x ' . @$gift->quantity,
            ]);
            $params = [
                'branch_id' => $gift->branch_id,
                'product_id' => $gift->product_id,
                'customer' => $gift->product_id,
            ];
            $doc = HistoryDepot::search($params)->where('status', OrderConstant::TANG_KHACH)->first();
            $productDepot = ProductDepot::search($params)->first();
            if (isset($productDepot) && $productDepot) {
                $productDepot->quantity = $productDepot->quantity - $gift->quantity;
                $productDepot->save();
            }
            if (isset($doc)){
                $doc->delete();
            }
            $gift->delete();

        } else {
            return back();
        }
    }
}
