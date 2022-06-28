<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Models\Category;
use App\Models\Services as Service;
use App\Models\Trademark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Response;

class ServiceController extends Controller
{
    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:services.list', ['only' => ['index']]);
        $this->middleware('permission:services.edit', ['only' => ['edit']]);
        $this->middleware('permission:services.add', ['only' => ['create']]);
        $this->middleware('permission:services.delete', ['only' => ['destroy']]);

        $this->list[0] = ('category.parent');
        $categories = Category::where('type', StatusCode::SERVICE)->orderBy('id', 'desc')->pluck('name', 'id')->prepend('--Chọn--', '')->toArray();
        $trademarks = Trademark::orderBy('id', 'desc')->pluck('name', 'id')->toArray();
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
        $docs = Service::where('type', StatusCode::SERVICE)->orderByDesc('images')->orderBy('id', 'desc')
            ->when(isset($input['category_id']) && $input['category_id'], function ($q) use ($input) {
                $q->where('category_id', $input['category_id']);
            })->when(isset($input['search']) && $input['search'], function ($q) use ($input) {
                $q->where('name', 'like', '%' . $input['search'] . '%')
                    ->orwhere('code', 'like', '%' . $input['search'] . '%')
                    ->orwhere('trademark', 'like', '%' . $input['search'] . '%')
                    ->orwhere('enable', 'like', '%' . $input['search'] . '%');
            });
        $docs = $docs->paginate(StatusCode::PAGINATE_10);
        $title = 'Quản lý dịch vụ';
        if ($request->ajax()) {
            return Response::json(view('service.ajax', compact('input', 'docs', 'title'))->render());
        }
        return view('service.index', compact('input', 'title', 'docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm dịch vụ';
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
        $input['description'] = $request->description ? str_replace('\r\n', '', $request->description) : 0;
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
        $title = 'Cập nhật dịch vụ';
        return view('service._form', compact('title', 'doc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->merge([
            'price_buy' => $request->price_buy ? str_replace(',', '', $request->price_buy) : 0,
            'price_sell' => $request->price_sell ? str_replace(',', '', $request->price_sell) : 0,
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
