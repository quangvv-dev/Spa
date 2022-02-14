<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\StatusCode;
use App\Models\Source;
use App\Services\FanpageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

class FanpageController extends Controller
{
    private $fanpage;

    public function __construct(FanpageService $fanpage)
    {
        $this->fanpage = $fanpage;
//        $source = Source::pluck('name', 'id')->toArray();
//        view()->share([
//            'source' => $source,
//        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fanpages = $this->fanpage->index($request)->paginate(StatusCode::PAGINATE_20);
        $source = Source::pluck('name', 'id')->toArray();
        if ($request->session()->has('login-facebook')) {
            $data_login_fb = $request->session()->get('login-facebook');
        } else {
            $data_login_fb = null;
        }
        if ($request->ajax()) {
            return view('marketing.fanpage.ajax', compact('fanpages', 'data_login_fb'));
        }
        return view('marketing.fanpage.index',compact('fanpages','data_login_fb','source'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function postLoginFB(Request $request)
    {
        return Socialite::driver('facebook')->scopes(['public_profile', 'email', 'pages_messaging','pages_read_engagement', 'pages_manage_metadata', 'pages_show_list'])->redirect();
    }

    public function callbackFB(Request $request)
    {
        dd(123);
        $user = Socialite::driver('facebook')->user();
        session(['login-facebook' => $user]);
        return redirect('/marketing/fanpage');
    }

    public function removeAccount(Request $request)
    {
        $request->session()->forget('login-facebook');
        return redirect(route('marketing.fanpage.index'));
    }
}
