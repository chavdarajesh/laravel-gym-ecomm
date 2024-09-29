<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class isAuth
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
        if (Auth::check()) {
            return $next($request);
        }
        if (FacadesRequest::segment(1) == 'admin') {
            return redirect()->route('admin.login.get')->with('error', 'Please Login To Access This Page..!');
        }
        if (FacadesRequest::segment(1) == 'user') {
            return redirect()->route('user.login.get')->with('error', 'Please Login To Access This Page..!');
        }
        return redirect()->route('front.home')->with('error', 'Please Login To Access This Page..!');
    }
}
