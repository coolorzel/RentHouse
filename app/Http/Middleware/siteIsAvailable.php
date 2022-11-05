<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class siteIsAvailable
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
        if (config('global.page_available', '1') == '0')
        {
            if (Auth::guest())
            {
                return redirect()->route('siteIsOff');
            }
            else{
                if (Auth::user()->can('ACP-visit-page-off'))
                {
                    return $next($request);
                }
                else{
                    return redirect()->route('siteIsOff');
                }
            }
        }
        return $next($request);
    }
}
