<?php

namespace App\Http\Controllers\BE\ThuChi;

use App\Models\DanhMucThuChi;
use App\Models\LyDoThuChi;
use App\Models\ThuChi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class LyDoController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:danh-muc-thu-chi.index', ['only' => ['index']]);
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
        $docs = LyDoThuChi::when(isset($request->name) && $request->name, function ($query) use ($request) {
            $query->where('name', $request->name);
        })->get();

        $categories = DanhMucThuChi::pluck('name','id')->toArray();
        if ($request->ajax()) {
            return Response::json(view('thu_chi.ly_do_thu_chi.ajax', compact('docs'))->render());
        }
        return view('thu_chi.ly_do_thu_chi.index', compact('docs','categories'));
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
        LyDoThuChi::create(['name'=>'']);
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
//        $doc = LyDoThuChi::find($id);
//        return view('thu_chi.category._form', compact('doc'));
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
        $category = LyDoThuChi::find($id);
        $category->update(['name'=>$request->name,'category_id'=>$request->category_id]);
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
        $ly_do = LyDoThuChi::find($id);
        $thu_chi = ThuChi::where('ly_do_id',$ly_do->id)->first();
        if ($thu_chi){
            return 0;
        } else {
            $ly_do->delete();
            return 1;
        }
    }
}
