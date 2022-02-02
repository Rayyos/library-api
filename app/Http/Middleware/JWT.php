<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Response;
use Exception;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use JWTAuth;
class JWT 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {     
        $user = JWTAuth::parseToken()->authenticate();
        return $next($request);

        // try {
        //     JWTAuth::parseToken()->authenticate();

        // } catch (Exception $e) {
        //     if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
        //        // return response()->json(['message' => 'Token is Invalid'],420);
        //         return response()->json([               
        //             'response' => 'Token is Invalid' // nothing to show 
        //           ]);
        //     }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
        //        // return response()->json(['message' => 'Token is Expired'],420);
        //         return response()->json([              
        //             'response' => 'Token is Expired' // nothing to show 
        //           ]);
        //     }else{
        //         //return response()->json(['message' => 'Authorization Token not found'],463);
        //         return response()->json([               
        //             'response' => 'Authorization Token not found' // nothing to show 
        //           ]);
        //     }
        // }
        //return $next($request);
    }
}
