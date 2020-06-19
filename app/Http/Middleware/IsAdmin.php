<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        //if (Auth::user() && Auth::user()->isAdmin()) {
        if (true) {
        //
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
