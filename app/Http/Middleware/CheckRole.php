<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        } elseif (!Auth::user()->hasRole($role)) {
            // if (Auth::user()->hasAdmin()) {
            //     return abort('404');
            // }
            return abort('404');
        }
        return $next($request);
    }
}
