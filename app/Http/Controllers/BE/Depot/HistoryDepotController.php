<?php

namespace App\Http\Controllers\BE\Depot;

use App\Constants\OrderConstant;
use App\Constants\StatusConstant;
use App\Models\Branch;
use App\Models\HistoryDepot;
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
            OrderConstant::HONG_VO  => 'Hàng rơi, hỏng',
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
        $docs = HistoryDepot::search($input)->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('history_depot.ajax', compact('docs'));
        }

        return view('history_depot.index', compact('docs'));
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
                $input['user_id'] = !empty(Auth::user()->id) ? Auth::user()->id : 0;
                $doc = ProductDepot::search($input)->first();
                if (isset($doc) && $doc) {
                    if (empty($request->quantity[$key]))
                        return redirect(route('depots.history.index'))->with('waring', 'Chưa điền số tiền');
                    if ($input['status'] == OrderConstant::NHAP_KHO && !empty($request->quantity[$key])) {
                        $doc->quantity = $doc->quantity + (int)$request->quantity[$key];
                    } elseif (in_array($input['status'], [OrderConstant::XUAT_KHO, OrderConstant::HONG_VO,OrderConstant::TIEU_HAO]) && !empty($request->quantity[$key])) {
                        $doc->quantity = $doc->quantity - (int)$request->quantity[$key];
                    }
                    $doc->save();
                    $input['quantity_rest'] = $doc->quantity;
                    $input['quantity'] = (int)$request->quantity[$key];
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
     * import excel
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $user_id = Auth::user()->id;
        if ($request->hasFile('file') && ($request->file('file')->getClientMimeType() == Setting::ExcelType || $request->file('file')->getClientMimeType() == Setting::ExcelTypeV2)) {
            Excel::load($request->file('file')->getRealPath(), function ($render) use ($user_id) {
                $result = $render->toArray();
                foreach ($result as $k => $row) {
                    if ($row['ma_san_pham']) {
                        $product = Product::where('code', $row['ma_san_pham'])->first();
                        $product_depot = ProductDepot::where('product_id', $product->id)->first();

                        $depot = Depot::where('name', $row['kho'])->first();
                        $status = $row['nghiep_vu'] == 'Nhập kho' ? 1 : ($row['nghiep_vu'] == 'Xuất kho' ? 2 : 3);
                        $quantity_rest = $status == 1 ? $product_depot->quantity + $row['so_luong'] : $product_depot->quantity - $row['so_luong'];
                        if (isset($product) && $product) {
                            $input = [
                                'depot_id' => $depot->id,
                                'product_id' => $product->id,
                                'quantity' => $row['so_luong'],
                                'status' => $status,
                                'note' => $row['ghi_chu'],
                                'user_id' => $user_id,
                                'quantity_rest' => $quantity_rest
                            ];

                            HistoryDepot::create($input);
                            $product_depot->update(['quantity' => $quantity_rest]);
                        } else {
                            return redirect()->back()->with('danger', 'Đã có lỗi xảy ra');
                        }

                    }
                }
            });
            return redirect()->back()->with('status', 'Tải lịch sử thành công');
        }
        return redirect()->back()->with('danger', 'File không đúng định dạng *xlsx');
    }
}
