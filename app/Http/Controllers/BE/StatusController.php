<?php

namespace App\Http\Controllers\BE;

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
        $types_pluck = [
            ''                          => '-Chọn loại nhớm-',
            StatusCode::SOURCE_CUSTOMER => 'Nguồn khách hàng',
            StatusCode::RELATIONSHIP    => 'Mối quan hệ',
            StatusCode::BRANCH          => 'Chi nhánh',
        ];

        view()->share([
            'types_pluck' => $types_pluck,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docs = Status::orderBy('position', 'asc');
        if ($request->search) {
            $docs = $docs->where('name', 'like', '%' . $request->search . '%')
                ->orwhere('type', 'like', '%' . $request->search. '%');
        }
        $docs = $docs->paginate(15);
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
     * @param Status                   $status
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Status $status)
    {
        $status->delete();
        $request->session()->flash('error', 'Xóa danh mục thành công!');
    }

    public function getList(Request $request)
    {
        $customerId = $request->id;
        $customer = Customer::with('status')->where('id', $customerId)->first();
        $statuses = Status::get();

        return $data = [
                'customer' => $customer,
                'data' => $statuses
            ];
    }
    public function updatePostion(Request $request)
    {
        $data = $request->all();
        foreach ($data['data'] as $key => $record) {
            Status::where('id',$record['id'])->update(['position'=>$record['position']]);
        }
    }
    public function updateColor(Request $request)
    {
        $data = $request->id;
        $color = Status::find($request->id);
        $color->color = $request->color;
        $color->save();
    }
}
