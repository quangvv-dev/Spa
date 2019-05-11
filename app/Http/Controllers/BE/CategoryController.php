<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Functions;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{

    var $list;

    public function __construct()
    {
        $this->list[0] = ('category.parent');
        $categories = Category::orderBy('parent_id', 'asc')->orderBy('id', 'desc')->get()->pluck('name', 'id')->prepend('Danh mục cha ...', 0)->toArray();
        view()->share([
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
        if ($request->ajax()) {
            return Response::json(view('category.ajax', compact('docs', 'title'))->render());
        }
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
        $text = Functions::vi_to_en(@$request->name);
        $request->merge(['code' => str_replace(' ', '_', strtolower($text))]);
        Category::create($request->all());
        return redirect(route('category.create'))->with('status', 'Tạo danh mục thành công');
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
    public function edit(Category $category)
    {
        $doc = $category;
        $title = 'Cập nhật danh mục';
        return view('category._form', compact('title', 'doc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $text = Functions::vi_to_en(@$request->name);
        $request->merge(['code' => str_replace(' ', '_', strtolower($text))]);
        $category->update($request->all());
        return redirect(route('category.index'))->with('status', 'Cập nhật danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        if (isset($category->categories)) {
            $request->session()->flash('error', 'Không thể xóa vì danh mục đang chứa danh mục con!');
        } else {
            $category->delete();
            $request->session()->flash('error', 'Xóa thành công danh mục!');
        }
    }
}
