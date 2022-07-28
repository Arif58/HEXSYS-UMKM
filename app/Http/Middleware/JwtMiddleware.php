<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        //BPJS pake x-token instead of Auth Bearer
        if(is_null($request->header('Authorization'))){
            $request->headers->set('Authorization', 'Bearer '.$request->header('x-token'));
        }
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            //     return response()->json([
            //     'metadata' => [
            //         'status' => 'unauthorized',
            //         'message' => 'Token Invalid',
            //         'code' => 401,
            //     ],
            // ]);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            //     return response()->json([
            //     'metadata' => [
            //         'status' => 'unauthorized',
            //         'message' => 'Token Expired',
            //         'code' => 401,
            //     ],
            // ]);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
        // return response()->json($request->header('Authorization'));
    }
}
