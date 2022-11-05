<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginIsOff
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
        if(Auth()->check() && (!Auth()->user()->can('ACP-login-despite-disabled-login')) && config('global.user_login_available', '1')  == 0){
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            toast(__('Login was disabled...'),'info');
            return redirect()->route('login');

        }
        return $next($request);
    }
}
