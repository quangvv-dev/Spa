<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Landipage;
use App\Components\Filesystem\Filesystem;
use App\User;
use Illuminate\Http\Request;

class LandipageController extends Controller
{

    private $fileUpload;

    public function __construct(Filesystem $fileUpload)
    {
        $this->middleware('permission:landipages.list', ['only' => ['index']]);
        $this->middleware('permission:landipages.edit', ['only' => ['edit']]);
        $this->middleware('permission:landipages.add', ['only' => ['create']]);
        $this->middleware('permission:landipages.delete', ['only' => ['destroy']]);
        $this->fileUpload = $fileUpload;

        $campaigns = Campaign::orderByDesc('id')->pluck('name', 'id')->toArray();
        $category = Category::orderByDesc('id')->pluck('name', 'id')->toArray();
        $sale = User::where('department_id', DepartmentConstant::TELESALES)->where('active', UserConstant::ACTIVE)->orderByDesc('id')
            ->pluck('full_name', 'id')->toArray();
        \View::share([
            'campaigns' => $campaigns,
            'category' => $category,
            'sale' => $sale
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Danh sách landipage';
        $docs = Landipage::orderByDesc('id')->paginate(StatusCode::PAGINATE_10);
        return view('landipage.list', compact('title', 'docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tạo bài đăng';
        return view('landipage._form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('image');
        if ($request->image) {
            $input['thumbnail'] = $this->fileUpload->uploadImageCustom($request->image, '/uploads/landipages/');
        }
        Landipage::create($input);
        return redirect(route('landipages.index'))->with('Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Landipage::where('slug', $id)->first();
        return view('landipage.index', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Landipage $landipage)
    {
        $title = 'Tạo bài đăng';
        $doc = $landipage;
        return view('landipage._form', compact('doc', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Landipage $landipage)
    {
        $input = $request->except('image');
        if ($request->image) {
            Functions::unlinkUpload2($landipage->thumbnail);
            $input['thumbnail'] = $this->fileUpload->uploadImageCustom($request->image, '/uploads/landipages/');
        }

        $landipage->update($input);
        return redirect(route('landipages.edit', $landipage->id))->with('chỉnh sửa thành công');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Landipage $landipage)
    {
        $landipage->delete();
        return 1;
    }
}
