<?php

namespace App\Http\Middleware;

use Help;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class verifAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        if(Help::check()) return $next($request);
        else return redirect()->route('cnxPage_A');
    }
}
