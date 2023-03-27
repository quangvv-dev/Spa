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
                $version = (float)substr(PHP_VERSION, 0, 3);
                if ($version < 7.4) {
                    $request->jwtUser = jwtDecode($jwt, array('HS256'));// phiên bản php 7.4 thì string || 7.2 thì array
                } else {
                    $request->jwtUser = jwtDecode($jwt, 'HS256');// phiên bản php 7.4 thì string || 7.2 thì array
                }
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
