<?php

namespace App\Http\Controllers\Auth;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function authenticated(Request $request, $user)
    {
        Auth::logout();
        return back()->with('error', 'Tài khoản bị khóa vui lòng liên hệ Admin!');
        if ($user->active == StatusCode::ON) {
            $user = Auth::user();
            $value = isset($_COOKIE['user']) ? $_COOKIE['user'] : '';
            if ($user->pc_name == null) {
                if (!empty($value)) {
                    $user->update(['pc_name' => $value]);
                } else {
                    $value_has = $user->id . rand(10, 999);
                    setcookie("user", $value_has, 2147483647);
                    $user->update(['pc_name' => $value_has]);
                }
            } elseif ($user->pc_name && $user->pc_name != $value && $user->pc_name != '0') {
                $this->guard()->logout();
                $request->session()->invalidate();
                return back()->with('error', 'Không phải thiết bị mà bạn đăng ký !!!');
            }
            Auth::logoutOtherDevices($request->password);
            return redirect('/customers');
        } else {
            Auth::logout();
            return back()->with('error', 'Tài khoản bị khóa vui lòng liên hệ Admin!');
        }
    }

//    public function logout(Request $request)
//    {
//        $this->guard()->logout();
//        $request->session()->invalidate();
//        return redirect('/login');
//    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }
}
