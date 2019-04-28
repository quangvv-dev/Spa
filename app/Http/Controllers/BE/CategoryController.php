<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    var $list;

    public function __construct()
    {
        $this->list[0] = ('category.parent');
//        $categories = Category::where('parent_id', 0)->where('id', '<>', 0)->orderBy('name', 'asc')->get();
        $categories = Category::orderBy('id', 'desc')->get()->pluck('name','id')->toArray();
//        $this->getList($categories, 0);
        view()->share([
//            'category_pluck' => $this->list,
            'category_pluck' => $categories,
        ]);
    }

    private function getList($list, $id, $str = '', $mang2 = [])
    {
        if (isset($list)) {
            foreach ($list as $key => $val) {
                if ($val->id != $id) {
                    $val->name = $str . $val->name;
                    $mang2[$val->id] = $val->name;
                    return $this->getList($val->categories, $val->id, $str . '|--', $mang2);
                }
            }
        } else {
            return $mang2;
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docs = Category::orderBy('id', 'desc');
        if ($request->search) {
            $docs = $docs->where('name', 'like', '%' . $request->search . '%')
                ->orwhere('code', 'like', '%' . $request->search . '%')
                ->orwhere('parent_id', 'like', '%' . $request->search . '%');
        }
        $docs = $docs->paginate(10);
        $title = 'Quản lý danh mục';
        return view('category.index', compact('title', 'docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Thêm mới danh mục';
        return view('category._form', compact('title'));
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
        //
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
        //
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
