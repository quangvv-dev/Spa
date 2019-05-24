<?php

namespace App\Http\Middleware;

use App\Constants\UserConstant;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role != UserConstant::ADMIN) {
            return redirect('/');
        }

        return $next($request);
    }
}
