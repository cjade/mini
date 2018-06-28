<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle ($request, Closure $next)
    {
        //判断用户是否登录
        if (!Auth::guard('api')->check()) {
            return jsonError(InvalidToken);
        }
        return $next($request);
    }
}
