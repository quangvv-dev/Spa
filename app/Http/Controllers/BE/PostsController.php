<?php

namespace App\Http\Controllers\BE;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Branch;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Post;
use App\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:posts.list', ['only' => ['index']]);
        $this->middleware('permission:posts.edit', ['only' => ['edit']]);
        $this->middleware('permission:posts.add', ['only' => ['create']]);
        $this->middleware('permission:posts.delete', ['only' => ['destroy']]);

        $campaigns = Campaign::orderByDesc('id')->pluck('name', 'id')->toArray();
        $branchs = Branch::pluck('name', 'id')->toArray();
        $category = Category::orderByDesc('id')->pluck('name', 'id')->toArray();
        $sale = User::where('department_id', DepartmentConstant::TELESALES)->where('active', UserConstant::ACTIVE)->orderByDesc('id')
            ->pluck('full_name', 'id')->toArray();
        \View::share([
            'campaigns' => $campaigns,
            'category'  => $category,
            'sale'      => $sale,
            'branchs'   => $branchs
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Danh sách OPTIN FORM';
        $docs = Post::orderByDesc('id')->paginate(StatusCode::PAGINATE_10);
        return view('post.list', compact('title', 'docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Tạo OPTIN FORM';
        return view('post._form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        Post::create($request->all());
        return redirect(route('posts.index'))->with('Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('slug', $id)->first();
        return view('post.index', compact('post'));
    }

    /**
     * View hiển thị form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showForm($id)
    {
        $title = 'Cấu hình Form';
        $post = Post::find($id);
        return view('optin_form._form', compact('post', 'title'));
    }

    public function showOptinForm($id)
    {
        $title = 'Cấu hình Form';
        $post = Post::find($id);
        return view('optin_form.index', compact('post', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $title = 'Tạo bài đăng';
        $doc = $post;
        return view('post._form', compact('doc', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return redirect(route('posts.edit', $post->id))->with('chỉnh sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return 1;
    }
}
