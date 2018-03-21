<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = 'Founder')
    {
        if (! \Auth::guard('api')->user()->hasRole($role)) {
            return response()->json(['msg' => '没有权限！'], 403);
        }
        return $next($request);
    }
}
