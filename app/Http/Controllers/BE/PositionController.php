<?php

namespace App\Http\Controllers\BE;

use App\Models\Department;
use App\Models\Position as Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $department = Department::find($id);
        $docs = Model::orderBy('id', 'desc')->where('department_id', $id);
        if ($request->search) {
            $docs = $docs->where('name', 'like', '%' . $request->search . '%');
        }
        $docs = $docs->paginate(10);
        $title = 'Danh sách chức vụ (' . $department->name . ')';
        if ($request->ajax()) {
            return Response::json(view('position.ajax', compact('docs', 'title', 'id'))->render());
        }
        return view('position.index', compact('title', 'docs', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->merge([
            'department_id' => $id,
        ]);
        Model::create($request->all());
        return redirect()->back();
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
    public function edit($id)
    {
        if ($id) {
            $data = Model::find($id);
            return $data;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Model::find($request->id);
        $data->update($request->except('id','_token'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
