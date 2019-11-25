<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdminOrSelf
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
        $requestedUserEmail = $request->route()->parameter('email');

        if ((Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') || Auth::user()->email == $requestedUserEmail) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthorized66'], 403);
        }
    }
}
