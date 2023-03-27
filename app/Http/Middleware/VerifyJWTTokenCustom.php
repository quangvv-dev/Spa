<?php

namespace App\Http\Middleware;

use App\Constants\ResponseStatusCode;
use Closure;

class VerifyJWTTokenCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $jwt = @trim(explode(' ', $request->header('Authorization'))[1]);
        if (empty($jwt)) {
            return response()->json([
                'code' => ResponseStatusCode::BAD_REQUEST,
                'messages' => 'Chưa nhập token !!!',
                'data' => []
            ]);
        } else {
            try {
                $request->jwtUser = jwtDecode($jwt, array('HS256'));
            } catch (\Exception $e) {
                return response()->json([
                    'code' => ResponseStatusCode::BAD_REQUEST,
                    'messages' => 'Token không hợp lệ !!!',
                    'data' => []
                ]);
            }
            return $next($request);
        }
    }
}
