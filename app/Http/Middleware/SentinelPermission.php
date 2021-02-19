<?php

namespace App\Http\Middleware;

use Closure;

class SentinelPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions = null)
    {
        $admin = $request->user()->load('roles');
        if ($admin && ($admin->permission($permissions))) {
            return $next($request);
        } else {
            return redirect('/403')->with('danger', 'Bạn không có quyền truy cập!');
        }
    }
}
