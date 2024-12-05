<?php

namespace App\Http\Controllers\BE\ThuChi;

use App\Models\DanhMucThuChi;
use App\Models\ThuChi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class DanhMucController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:danh-muc-thu-chi.index', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $docs = DanhMucThuChi::when(isset($request->name) && $request->name, function ($query) use ($request) {
            $query->where('name', $request->name);
        })->orderByDesc('id')->get();

        if ($request->ajax()) {
            return Response::json(view('thu_chi.category.ajax', compact('docs'))->render());
        }
        return view('thu_chi.category.index', compact('docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('thu_chi.category._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DanhMucThuChi::create(['name'=>'']);
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doc = DanhMucThuChi::find($id);
        return view('thu_chi.category._form', compact('doc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = DanhMucThuChi::find($id);
        $category->update(['name'=>$request->name]);
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = DanhMucThuChi::find($id);
        $thu_chi = ThuChi::where('danh_muc_thu_chi_id',$category->id)->first();
        if ($thu_chi){
            return 0;
        } else {
            $category->delete();
            return 1;
        }
    }
}
