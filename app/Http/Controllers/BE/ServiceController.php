<?php

namespace App\Http\Controllers\BE;

use App\Models\Category;
use App\Models\Services as Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Functions;

class ServiceController extends Controller
{
    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->list[0] = ('category.parent');
        $categories = Category::orderBy('id', 'desc')->get()->pluck('name', 'id')->prepend('--Chọn--', '')->toArray();
        view()->share([
            'category_pluck' => $categories,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docs = Service::orderBy('id', 'desc');
        if ($request->search) {
            $user = $docs->where('name', 'like', '%' . $request->search . '%')
                ->orwhere('code', 'like', '%' . $request->search . '%')
                ->orwhere('trademark', 'like', '%' . $request->search . '%')
                ->orwhere('enable', 'like', '%' . $request->search . '%');
        }
        $docs = $docs->paginate(10);
        $title = 'Quản lý dịch vụ';
        return view('service.index', compact('title', 'docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm trạng thái';
        return view('service._form', compact('title'));
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
        $data = Service::create($input);
        $data->update([
            'code' => $data->id,
        ]);
        return redirect(route('services.create'))->with('status', 'Tạo dịch vụ thành công');

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
    public function edit(Service $service)
    {
        $doc = $service;
        $title = 'Cập nhật trạng thái';
        return view('service._form', compact('title', 'doc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->merge([
            'price_buy'       => $request->price_buy ? str_replace(',', '', $request->price_buy) : 0,
            'price_sell'      => $request->price_sell ? str_replace(',', '', $request->price_sell) : 0,
            'promotion_price' => $request->promotion_price ? str_replace(',', '', $request->promotion_price) : 0,
        ]);
        $image = Functions::checkUploadImage($request, $service, 'services');
        $service->update($request->except('img_file', 'image'));
        return redirect('services/' . $service->id . '/edit')->with('status', 'Cập nhật dịch vụ thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        if ($service->images) {
            foreach ($service->images as $k => $v) {
                Functions::unlinkUpload('services', @$v);
            }
        }
        $service->delete();
    }
}
