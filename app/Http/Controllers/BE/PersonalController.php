<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->users = $userService;
    }

    public function salary(Request $request, User $user)
    {
        $month = $request->month ?: date('m');
        $year = $request->year?:date('Y');
        $docs = Salary::where('approval_code',$user->code)->where('month',$month)->where('year',$year)->first();
        if($docs){
            $key = json_decode($docs->data)->key;
            $value = json_decode($docs->data)->value;
        } else {
            $key = [];
            $value = [];
        }
        if($request->ajax()){
            return view('users.include._form-salary',compact('docs','key','value','user'));
        }
        return view('users.include.salary-index',compact('docs','key','value','user'));
    }
}
