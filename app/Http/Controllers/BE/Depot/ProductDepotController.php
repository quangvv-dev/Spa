<?php

namespace App\Http\Controllers\BE\Depot;

use App\Models\Branch;
use App\Models\HistoryDepot;
use App\Models\Services;
use App\Models\ProductDepot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants\StatusCode;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductDepostService;
use Excel;

class ProductDepotController extends Controller
{

    private $productDepost;

    public function __construct(ProductDepostService $productDepost)
    {
        $this->productDepost = $productDepost;
        $product = Services::where('type', StatusCode::PRODUCT)->pluck('name', 'id')->toArray();
        $deposts = Branch::pluck('name', 'id')->toArray();
        view()->share([
            'products' => $product,
            'deposts' => $deposts,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $checkRole = checkRoleAlready();
        if (!empty($checkRole)) {
            $input['branch_id'] = $checkRole;
        }
        $docs = ProductDepot::search($request->all())->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('product_depot.ajax', compact('docs','checkRole'));
        }

        return view('product_depot.index', compact('docs','checkRole'));
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
        $already = ProductDepot::search($request->all())->first();
        if (!empty($already)) {
            return 0;
        }
        $input = $request->all();
        $input['quantity'] = 0;
        $input['user_id'] = Auth::user()->id;
        $this->productDepost->create($input);
        return 1;
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
        $this->productDepost->delete($id);

        return 1;
    }

    public function getAll()
    {
        $search = [];
        $product = ProductDepot::search($search)->groupBy('product_id')->with('product')->get();
        return response()->json([
            'product' => $product
        ]);
    }

    public function getDetail($id)
    {
        $search['branch_id'] = $id;
        $product = ProductDepot::search($search)->with('product')->get();
        return response()->json([
            'product' => $product
        ]);
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {

            Excel::load($request->file('file')->getRealPath(), function ($render) {
                $input['user_id'] = Auth::user()->id;
                $result = $render->toArray();
                foreach ($result as $k => $row) {
                    $type = $row['nghiep_vu'] == 'NHẬP KHO' ? 1 : ($row['nghiep_vu'] == 'XUẤT KHO' ? 2 : ($row['nghiep_vu'] == 'TIÊU HAO' ? 3 : 4));

                    $product = Services::where('name', 'like', '%' . $row['san_pham'] . '%')->first();
                    $branch = Branch::where('name', $row['chi_nhanh'])->first();
                    if (isset($product) && isset($branch)) {
                        $product_depot = ProductDepot::where('branch_id', $branch->id)->where('product_id', $product->id)->first();
                        if (!isset($product_depot)) {
                            ProductDepot::create([
                                'branch_id' => $branch->id,
                                'product_id' => $product->id,
                                'quantity' => $row['so_luong'],
                            ]);
                        } else {
                            $current_quantity = $type == 1 ? $product_depot->quantity + $row['so_luong'] : $product_depot->quantity - $row['so_luong'];
                            $product_depot->quantity = $current_quantity;
                            $product_depot->save();
                        }

                        // Tạo lịch sử nhập xuất
                        HistoryDepot::create([
                            'branch_id' => $branch->id,
                            'product_id' => $product->id,
                            'quantity' => $row['so_luong'],
                            'status' => $type,
                            'user_id' => $input['user_id'],
                        ]);
                    }
                }
            });
        }
        return back();
    }
}
