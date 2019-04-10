<?php

namespace Pheaks\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Pheaks\Http\Libraries\Flash;

class Admin
{
    protected $auth;
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->auth->user()->admin()){
            return $next($request);
        }else{
            //Flash::toastWarning('Persion denied');
            //return redirect('/')->with(['flash'=>Flash::all()]);
            return abort(404);
        }
    }
}
