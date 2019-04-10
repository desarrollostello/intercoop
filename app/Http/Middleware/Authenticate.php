<?php

namespace Pheaks\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Pheaks\Http\Libraries\Flash;
use Redirect;
use Request;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                Flash::toastWarning('Please login');
                return redirect()->guest('auth/login')->with('flash', Flash::all());
            }
        }

        return $next($request);
    }
}
