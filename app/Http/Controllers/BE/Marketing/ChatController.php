<?php

namespace App\Http\Controllers\BE\Marketing;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Models\Customer;
use App\Models\Fanpage;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('marketing.chat_fanpage.chat_one_page');
    }

    public function chatFanpage(Request $request){
        $data = $request->all();
        $data['used'] = 1;
        $paginate = $request->customPage ?: StatusCode::PAGINATE_20;
        $user = Auth::user();
        if($user->department_id == DepartmentConstant::MARKETING)
        {
            $data['searchUser'] = $user->id;
        }
        $fanpages = Fanpage::search($data)->paginate($paginate);
        $mkts = User::where('department_id',DepartmentConstant::MARKETING)->get();
        if($request->ajax()){
            return view('marketing.chat_fanpage.ajax',compact('fanpages','mkts', 'paginate'));
        }
        return view('marketing.chat_fanpage.index',compact('fanpages','mkts', 'paginate'));
    }

    public function chatMultiPage(){
        return view('marketing.chat_fanpage.chat_multi_page');
    }

    public function getFanpageToken($id)
    {
        $page = Fanpage::where('page_id', $id)->first();
        return response()->json([
            'code' => 200,
            'data' => $page,
        ]);
    }
    public function getPhonePage(Request $request){
        return Customer::select('phone','page_id','FB_ID')->whereIn('page_id',$request->arr_page)->get();
    }
}
