<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\FanpageConstant;
use App\Constants\StatusCode;
use App\Helpers\Functions;
use App\Models\Fanpage;
use App\Models\FanpagePost;
use App\Models\Post;
use App\Models\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FanpagePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      dd( public_path());
        $source = Source::pluck('name', 'id')->toArray();
        $my_page = Fanpage::pluck('name', 'id')->toArray();
        $posts = FanpagePost::paginate(StatusCode::PAGINATE_20);
//        dd($posts);
        if ($request->ajax()) {
            return view('marketing.fanpage_post.ajax', compact('posts'));
        }
        return view('marketing.fanpage_post.index',compact('posts','my_page','source'));
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
        $uri = 'https://graph.facebook.com/v10.0/me/posts';
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
        //
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
}
