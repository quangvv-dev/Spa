<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Models\Category;
use App\Models\Trademark;
use App\Models\Services as Service;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Functions;
use Excel;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:products.list', ['only' => ['index']]);
        $this->middleware('permission:products.edit', ['only' => ['edit']]);
        $this->middleware('permission:products.add', ['only' => ['create']]);
        $this->middleware('permission:products.delete', ['only' => ['destroy']]);

        $this->list[0] = ('category.parent');
        $categories = Category::where('type', StatusCode::PRODUCT)->orderBy('id', 'desc')->get()->pluck('name', 'id')->prepend('--Chọn--', '')->toArray();
        $trademarks = Trademark::get()->pluck('name', 'id');
        view()->share([
            'category_pluck' => $categories,
            'trademarks' => $trademarks,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $docs = Service::where('type', StatusCode::PRODUCT)->orderBy('id', 'desc')
            ->when(isset($input['category_id']) && $input['category_id'], function ($q) use ($input) {
                $q->where('category_id', $input['category_id']);
            })->when(isset($input['trademark']), function ($q) use ($input) {
                $q->where('trademark', $input['trademark']);
            })
            ->when(isset($input['search']) && $input['search'], function ($q) use ($input) {
                $q->where('name', 'like', '%' . $input['search'] . '%')
                    ->orwhere('code', 'like', '%' . $input['search'] . '%')
                    ->orwhere('trademark', 'like', '%' . $input['search'] . '%')
                    ->orwhere('enable', 'like', '%' . $input['search'] . '%');
            });
        $docs = $docs->orderByDesc('images')->orderByDesc('id')->paginate(StatusCode::PAGINATE_10);

        $title = 'Quản lý sản phẩm';
        if ($request->ajax()) {
            return Response::json(view('product.ajax', compact('docs', 'title', 'input'))->render());
        }
        return view('product.index', compact('title', 'docs', 'input'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm sản phẩm';
        return view('product._form', compact('title'));
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
        $input = $request->except('img_file');
        if ($request->hasFile('img_file')) {
            $imgs = [];
            if ($request->img_file) {
                foreach (@$request->img_file as $k => $v) {
                    $img = Functions::uploadImage($v, 'services');
                    $imgs[] = $img;
                }
            }
            $input['images'] = @json_encode($imgs);
        }
        $input['price_buy'] = $request->price_buy ? str_replace(',', '', $request->price_buy) : 0;
        $input['price_sell'] = $request->price_sell ? str_replace(',', '', $request->price_sell) : 0;
        $input['promotion_price'] = $request->promotion_price ? str_replace(',', '', $request->promotion_price) : 0;
        $input['type'] = StatusCode::PRODUCT;
        $data = Service::create($input);
        $data->update([
            'code' => $data->id,
        ]);

        return redirect(route('products.create'))->with('status', 'Tạo sản phẩm thành công');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $product)
    {
        $doc = $product;
        $title = 'Cập nhật sản phẩm';
        return view('product._form', compact('title', 'doc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $product)
    {
        $request->merge([
            'price_buy' => $request->price_buy ? str_replace(',', '', $request->price_buy) : 0,
            'price_sell' => $request->price_sell ? str_replace(',', '', $request->price_sell) : 0,
            'promotion_price' => $request->promotion_price ? str_replace(',', '', $request->promotion_price) : 0,
        ]);
        $image = Functions::checkUploadImage($request, $product, 'services');
        $product->update($request->except('img_file', 'image'));
        return redirect('products/' . $product->id . '/edit')->with('status', 'Cập nhật sản phẩm thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $product)
    {
        if ($product->images) {
            foreach ($product->images as $k => $v) {
                Functions::unlinkUpload('services', @$v);
            }
        }
        $product->delete();
    }

    /**
     * Export data service type Product
     */
    public function exportData()
    {
        $now = Carbon::now()->format('d/m/Y');
        $data = Service::where('type', StatusCode::PRODUCT)->with('category')->get();

        Excel::create('Danh sách sản phẩm (' . $now . ')', function ($excel) use ($data) {
            $excel->sheet('Sheet 1', function ($sheet) use ($data) {
                $sheet->cell('A1:H1', function ($row) {
                    $row->setBackground('#008686');
                    $row->setFontColor('#ffffff');
                });
                $sheet->row(1, [
                    'Mã sản phẩm',
                    'Tên',
                    'Danh mục',
                    'Mô tả',
                    'Giá bán',
                    'Trạng thái',
                    'Ngày tạo',
                    'Chú ý',
                ]);
                $i = 1;
                if ($data) {
                    foreach ($data as $k => $ex) {
                        $i++;
                        $sheet->row($i, [
                            @$ex->id,
                            @$ex->name,
                            @$ex->category->name,
                            @$ex->description,
                            @$ex->price_sell,
                            @$ex->enable == UserConstant::ACTIVE ? 'Kinh doanh' : 'Ngừng kinh doanh',
                            @$ex->created_at,
                            @$i == 2 ? 'Đẩy data: - Vui lòng nhập tên danh mục chính xác có trong hệ thống.' .
                                ' - Chỉnh sửa vui lòng nhập mã sản phẩm/DV, tạo mới thì bỏ trống mã sản phẩm /DV.
                            ' : '',
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }

    /**
     * import product
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importData(Request $request)
    {
        if ($request->hasFile('file')) {
            Excel::load($request->file('file')->getRealPath(), function ($render) {
                $result = $render->toArray();
                foreach ($result as $k => $row) {
                    if ($row['danh_muc']) {
                        $category = Category::where('name', 'like', '%' . $row['danh_muc'] . '%')->first();
                        if (isset($category) && $category) {
                            $input['category_id'] = $category->id;
                            $input['name'] = $row['ten'];
                            $input['description'] = $row['mo_ta'] ?: null;
                            $input['price_sell'] = @(int)$row['gia_ban'];
                            $input['type'] = StatusCode::PRODUCT;
                            $input['enable'] = UserConstant::ACTIVE;
                            if (!$row['ma_san_pham']) {
                                $service = Service::create($input);
                                $service->update(['code' => $service->id]);
                            } else {
                                $service = Service::find($row['ma_san_pham']);
                                $service ? $service->update($input) : '';
                            }
                        }
                    }

                }
            });
        }
        return redirect()->back()->with('status', 'Tải sản phẩm thành công');
    }
}
