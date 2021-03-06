<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdmin
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
        if (Auth::user() && (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')) {
            return $next($request);
        } else {
            return response()->json([
                'error' => 'Unauthorized',
                'middleware' => 'isAdmin' // debug
            ], 403);
        }
    }
}
