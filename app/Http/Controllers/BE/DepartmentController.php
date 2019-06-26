<?php

namespace App\Http\Controllers\BE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department as Model;
use Illuminate\Support\Facades\Response;

class DepartmentController extends Controller
{

    public function __construct()
    {
        $categories = Model::orderBy('id', 'asc')->get()->pluck('name', 'id')->toArray();
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
        $docs = Model::orderBy('id', 'asc');
        if ($request->search) {
            $docs = $docs->where('name', 'like', '%' . $request->search . '%')
                ->orwhere('parent_id', 'like', '%' . $request->search . '%');
        }
        $docs = $docs->paginate(10);
        $title = 'Quản lý phòng ban';
        if ($request->ajax()) {
            return Response::json(view('department.ajax', compact('docs', 'title'))->render());
        }
        return view('department.index', compact('title', 'docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm mới phòng ban';
        return view('department._form', compact('title'));
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
        Model::create($request->except('_token'));
        return redirect(route('department.create'))->with('status', 'Tạo danh mục phòng ban');
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
    public function edit(Model $department)
    {
        $doc = $department;
        $title = 'Cập nhật phòng ban';
        return view('department._form', compact('title', 'doc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Model $department)
    {
        $doc = $department;
        $doc->update($request->except('_token'));
        return redirect(route('department.index'))->with('status', 'Cập nhật danh mục phòng ban');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Model $department)
    {
        $doc = $department;
        if (count($doc->child())) {
            $request->session()->flash('error', 'Không thể xóa vì phòng ban đang được trực thuộc phòng ban khác!');
        } else {
            $doc->delete();
            $request->session()->flash('error', 'Xóa thành công danh mục!');
        }
    }
}
