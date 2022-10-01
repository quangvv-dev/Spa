<?php

namespace App\Http\Controllers\BE\Depot;

use App\Constants\OrderConstant;
use App\Constants\StatusConstant;
use App\Helpers\Functions;
use App\Models\Branch;
use App\Models\Gift;
use App\Models\HistoryDepot;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Services;
use App\Models\ProductDepot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants\StatusCode;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductHistoryService;
use App\Services\ProductDepostService;
use Excel;

class HistoryDepotController extends Controller
{

    private $historyDepot;
    private $productDepot;

    public function __construct(ProductHistoryService $historyDepot, ProductDepostService $productDepot)
    {
        $this->historyDepot = $historyDepot;
        $this->productDepot = $productDepot;
        $product = Services::select('id', 'name')->where('type', StatusCode::PRODUCT)->pluck('name', 'id')->prepend('Tất cả', '')->toArray();
        $deposts = Branch::select('id', 'name')->pluck('name', 'id')->toArray();
        $status = [
            OrderConstant::NHAP_KHO => 'Nhập kho',
            OrderConstant::XUAT_KHO => 'Xuất kho',
            OrderConstant::TIEU_HAO => 'Vật phẩm tiêu hao',
            OrderConstant::HONG_VO => 'Hàng rơi, hỏng',
        ];

        view()->share([
            'products' => $product,
            'deposts' => $deposts,
            'status' => $status,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->except('name');
        $checkRole = checkRoleAlready();
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        }

        $docs = HistoryDepot::search($input)->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('history_depot.ajax', compact('docs', 'checkRole'));
        }

        return view('history_depot.index', compact('docs', 'checkRole'));
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
        $input = $request->except('product', 'quantity');
        if (!empty($request->product) && count($request->product) && count($request->quantity)) {
            foreach ($request->product as $key => $item) {
                $input['product_id'] = $item;
                $input['quantity'] = (int)$request->quantity[$key]?:0;
                $input['user_id'] = !empty(Auth::user()->id) ? Auth::user()->id : 0;
                $doc = ProductDepot::search($input)->first();
                if (isset($doc) && $doc) {
                    if (empty($request->quantity[$key]))
                        return redirect(route('depots.history.index'))->with('waring', 'Chưa điền số tiền');
                    if ($input['status'] == OrderConstant::NHAP_KHO && !empty($request->quantity[$key])) {
                        $doc->quantity = $doc->quantity + (int)$request->quantity[$key];
                    } elseif (in_array($input['status'], [OrderConstant::XUAT_KHO, OrderConstant::HONG_VO, OrderConstant::TIEU_HAO]) && !empty($request->quantity[$key])) {
                        $doc->quantity = $doc->quantity - (int)$request->quantity[$key];
                    }
                    $doc->save();
                    $this->historyDepot->create($input);
                } else {
                    ///check chưa nhập
                    if ($input['status'] == OrderConstant::NHAP_KHO && !empty($request->quantity[$key])) {
                        ProductDepot::create([
                            'branch_id' => $request->branch_id,
                            'product_id' => $input['product_id'],
                            'quantity' => $input['quantity'] ?: 0,
                        ]);
                    } elseif (in_array($input['status'], [OrderConstant::XUAT_KHO, OrderConstant::HONG_VO, OrderConstant::TIEU_HAO]) && !empty($request->quantity[$key])) {
                        ProductDepot::create([
                            'branch_id' => $request->branch_id,
                            'product_id' => $input['product_id'],
                            'quantity' => $input['quantity']?(-$input['quantity']): 0,
                        ]);
                    }
                    $this->historyDepot->create($input);

                }
            }

        }
        return redirect(route('depots.history.index'))->with('success', 'Thao tác thành công');
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
        $this->historyDepot->delete($id);

        return 1;
    }

    /**
     * Thống kê
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statistical(Request $request)
    {
        if (!$request->start_date) {
            Functions::addSearchDateTime($request);
        }
        $input = $request->all();
        $checkRole = checkRoleAlready();
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        }

        $docs = ProductDepot::select('branch_id', 'product_id', 'quantity')
            ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                $q->where('branch_id', $input['branch_id']);
            })->when(isset($input['product_id']) && $input['product_id'], function ($q) use ($input) {
                $q->where('product_id', $input['product_id']);
            })->get()->map(function ($item) use ($input) {
                $item->xuat_ban = OrderDetail::select('quantity')->where('booking_id', $item->product_id)
                    ->when(isset($input['branch_id']) && $input['branch_id'], function ($q) use ($input) {
                        $q->where('branch_id', $input['branch_id']);
                    })->whereBetween('created_at', [
                        Functions::yearMonthDayTime($input['start_date']),
                        Functions::yearMonthDayTime($input['end_date']),
                    ])->sum('quantity');
                $item->tieu_hao = HistoryDepot::select('quantity')->where('product_id', $item->product_id)
                    ->whereIn('status', [OrderConstant::TIEU_HAO, OrderConstant::HONG_VO, OrderConstant::XUAT_KHO])
                    ->whereBetween('created_at', [
                        Functions::yearMonthDayTime($input['start_date']),
                        Functions::yearMonthDayTime($input['end_date']),
                    ])->sum('quantity');
                $params = $input;
                $params['product_id'] = $item->product_id;
                $gifts =  Gift::search($params)->select('id','order_id','quantity');
                $item->quantityGifts = $gifts->sum('quantity');
                $item->orderGifts = $gifts->get()->count();
                return $item;
            })->sortByDesc('quantityGifts');

        if ($request->ajax()) {
            return view('history_depot.statisticalAjax', compact('docs', 'checkRole'));
        }

        return view('history_depot.statistical', compact('docs', 'checkRole'));
    }
}
