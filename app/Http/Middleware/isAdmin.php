<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class isAdmin
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
        if (Auth::check() && Auth::user()->is_admin == 1 && Auth::user()->role == 'admin') {
            return $next($request);
        }
        if (FacadesRequest::segment(1) == 'admin') {
            return redirect()->route('admin.login.get')->with('error', "You don't have permission to access this page!");
        }
        if (FacadesRequest::segment(1) == 'user') {
            return redirect()->route('user.login.get')->with('error', "You don't have permission to access this page!");
        }
        return redirect()->route('front.home')->with('error', "You don't have permission to access this page!");
    }
}
