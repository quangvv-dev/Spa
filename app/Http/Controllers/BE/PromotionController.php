<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Models\Promotion;
use App\Constants\PromotionConstant;
use App\Models\Services;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Response;

class PromotionController extends Controller
{
    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:promotions.list', ['only' => ['index']]);
        $this->middleware('permission:promotions.edit', ['only' => ['edit']]);
        $this->middleware('permission:promotions.add', ['only' => ['create']]);
        $this->middleware('permission:promotions.delete', ['only' => ['destroy']]);

        $type = [
            '' => 'TẤT CẢ',
            PromotionConstant::PERCENT => 'THEO %',
            PromotionConstant::MONEY => 'THEO TIỀN',
        ];
        $status = Status::where('type', StatusCode::RELATIONSHIP)->pluck('name', 'id')->toArray();
        $services = Services::where('type', StatusCode::SERVICE)->pluck('name', 'id')->toArray();
        view()->share([
            'type' => $type,
            'status' => $status,
            'services' => $services,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docs = Promotion::search($request->all());
        $docs = $docs->paginate(StatusCode::PAGINATE_20);

        $title = 'Quản voucher';
        if ($request->ajax()) {
            return Response::json(view('promotions.ajax', compact('docs', 'title'))->render());
        }
        return view('promotions.index', compact('title', 'docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tạo mới voucher';
        return view('promotions._form', compact('title'));
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
        $input = $request->all();
        $input['money_promotion'] = $request->money_promotion ? str_replace(',', '', $request->money_promotion) : 0;
        $input['min_price'] = $request->min_price ? str_replace(',', '', $request->min_price) : 0;
        $input['max_discount'] = $request->max_discount ? str_replace(',', '', $request->max_discount) : '';
        $input['current_quantity'] = $request->current_quantity ? str_replace(',', '', $request->current_quantity) : 0;
        $data = Promotion::create($input);
        $data->code = Functions::generateRandomString(6);
        $data->save();
        return redirect(route('promotions.create'))->with('status', 'Tạo dịch vụ thành công');

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
    public function edit(Promotion $promotion)
    {
        $doc = $promotion;
        $title = 'Cập nhật voucher';
        if ($promotion->type == PromotionConstant::PERCENT) {
            return view('promotions._form_percent', compact('title', 'doc'));
        } else {
            return view('promotions._form_money', compact('title', 'doc'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        $input = $request->all();
        $input['money_promotion'] = $request->money_promotion ? str_replace(',', '', $request->money_promotion) : 0;
        $input['min_price'] = $request->min_price ? str_replace(',', '', $request->min_price) : 0;
        $input['max_discount'] = $request->max_discount ? str_replace(',', '', $request->max_discount) : '';
        $input['current_quantity'] = $request->current_quantity ? str_replace(',', '', $request->current_quantity) : 0;
        $promotion->update($input);
        return redirect(route('promotions.edit', $promotion->id))->with('status', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Promotion $promotion
     * @throws \Exception
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
    }


}
