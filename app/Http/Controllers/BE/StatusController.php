<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusConstant;
use App\Helpers\Functions;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Constants\StatusCode;
use Illuminate\Support\Facades\Response;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:status.list', ['only' => ['index']]);
        $this->middleware('permission:status.edit', ['only' => ['edit']]);
        $this->middleware('permission:status.add', ['only' => ['create']]);
        $this->middleware('permission:status.delete', ['only' => ['destroy']]);

        $types_pluck = [
            '' => '-Chọn loại nhóm-',
            StatusCode::SOURCE_CUSTOMER => 'Nguồn khách hàng',
            StatusCode::RELATIONSHIP => 'Mối quan hệ',
            StatusCode::BRANCH => 'Chi nhánh',
        ];

        view()->share([
            'types_pluck' => $types_pluck,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */

    public function index(Request $request)
    {
        $docs = Status::orderBy('position', 'asc');
        if ($request->search) {
            $docs = $docs->where('name', 'like', '%' . $request->search . '%')
                ->orwhere('type', 'like', '%' . $request->search . '%');
        }
        $docs = $docs->paginate(StatusCode::PAGINATE_20);
        $title = 'Quản lý trạng thái';
        if ($request->ajax()) {
            return Response::json(view('status.ajax', compact('docs', 'title'))->render());
        }
        return view('status.index', compact('title', 'docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm trạng thái';
        return view('status._form', compact('title'));
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
        $text = Functions::vi_to_en(@$request->name);
        $request->merge(['code' => str_replace(' ', '_', strtolower($text))]);
        Status::create($request->all());
        return redirect(route('status.create'))->with('status', 'Tạo nhóm thành công');
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
    public function edit(Status $status)
    {
        $doc = $status;
        $title = 'Quản lý trạng thái';
        return view('status._form', compact('title', 'doc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Status $status
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $text = Functions::vi_to_en(@$request->name);
        $request->merge(['code' => str_replace(' ', '_', strtolower($text))]);
        $status->update($request->all());
        return redirect(route('status.index'))->with('status', 'Sửa nhóm thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Status $status
     * @throws \Exception
     */
    public function destroy(Request $request, Status $status)
    {
        if ($status->customers->count() == 0) {
            $status->delete();
            $request->session()->flash('error', 'Xóa danh mục thành công!');
        } else {
            $request->session()->flash('error', 'Tồn tại khách hàng thuộc nhóm. Không thể xóa!');
        }
    }

    public function getList(Request $request)
    {
        $customerId = $request->id;
        $customer = Customer::with('status')->where('id', $customerId)->first();
        $statuses = Status::where('type',StatusCode::RELATIONSHIP)->get();

        return $data = [
            'customer' => $customer,
            'data' => $statuses
        ];
    }

    /**
     * sap xep thu tu hien thi
     *
     * @param Request $request
     */
    public function updatePostion(Request $request)
    {
        $data = $request->all();
        foreach ($data['data'] as $key => $record) {
            Status::where('id', $record['id'])->update(['position' => $record['position']]);
        }
    }

    /**
     * cap nhat mau sac trang thai
     *
     * @param Request $request
     */
    public function updateColor(Request $request)
    {
        $color = Status::find($request->id);
        $color->color = $request->color;
        $color->save();
    }
}
