<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\FanpageConstant;
use App\Constants\StatusCode;
use App\Constants\StatusConstant;
use App\Helpers\Functions;
use App\Models\Fanpage;
use App\Models\FanpagePost;
use App\Models\Post;
use App\Models\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class FanpagePostController extends Controller
{

    public function __construct(){
        $this->middleware('permission:marketing.fanpage_post', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $my_page = Fanpage::where('user_id',$user->id)->pluck('name', 'id')->toArray();
        $data = [];
        if($user->permission('source.update')){
            $source = Source::pluck('name', 'id')->toArray();
        } else {
            $data['searchUser'] = $user->id;
            $source = Source::where('mkt_id',$user->id)->pluck('name', 'id')->toArray();
        }

        $arr_fanpage_id = Fanpage::search($data)->pluck('page_id')->toArray();

        if (count($arr_fanpage_id)) {
            $request['searchPage_Post'] = $arr_fanpage_id;
            $posts = FanpagePost::search($request)->paginate(StatusCode::PAGINATE_20);
        } else {
            $posts = [];
        }

        if ($request->ajax()) {
            return view('marketing.fanpage_post.ajax', compact('posts','source'));
        }
        return view('marketing.fanpage_post.index',compact('posts','source','my_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request)
    {
        $token = $request->access_token;
        $method = 'GET';
        $uri = 'https://graph.facebook.com/v16.0/me/posts';
        $field = '';

        $datas = Functions::getDataFaceBook($token, $method, $uri, $field);
        $lenght = count($datas) > $request->total_post ? $request->total_post : count($datas);
        for ($i = 0; $i < $lenght; $i++) {
            $date = date_create($datas[$i]->created_time);
            $post_id = explode('_', $datas[$i]->id)[1];

            $post = FanpagePost::where('post_id', $post_id)->first();
            if ($post) {
                $post->access_token = $token;
                $post->save();
            } else {
                FanpagePost::create([
                    'access_token'  => $token,
                    'page_id'       => $request->page_id,
                    'post_id'       => $post_id,
                    'title'         => isset($datas[$i]->message) ? $datas[$i]->message : '',
                    'post_created'  => $date,
                    'used'          => FanpageConstant::FANPAGE_POST_USED,
                    'source_id'     => $request->source_id ?: 0
                ]);
            }
        }
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
        //
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
        $model = FanpagePost::find($id);
        $model->update($request->except('_token'));
        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeCustom(Request $request)
    {
        $page = Fanpage::where('id', $request->page_id)->where('used', StatusConstant::ACTIVE)->first();
        if (isset($page)) {
            FanpagePost::create([
                'access_token' => $page->access_token,
                'page_id' => $page->page_id,
                'post_id' => $request->post_id,
                'title' => $request->title,
                'post_created' => Date::now()->format('Y-m-d H:i'),
                'used' => FanpageConstant::FANPAGE_POST_USED,
                'source_id' => $page->source_id
            ]);
            return back()->with('success', 'Thêm bài viết thành công !!!');
        } else {
            return back()->with('error', 'Fanpage chưa được sử dụng !!!');
        }

    }
}
