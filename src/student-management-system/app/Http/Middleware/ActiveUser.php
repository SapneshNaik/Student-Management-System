<?php

namespace App\Http\Middleware;

use Closure;

class ActiveUser
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
        $response = $next($request);

        if($request->user() == null || $request->user()->canLogin()){
            return $response;
        } else {
            //TODO: revoke any existing tokens
            return response()->json([
                'message' => 'User login disabled'
            ], 401);
        }
    }
}
