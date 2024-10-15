<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class checkLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Get the authenticated user
    $user_status = ['admin','writer'];
    if(!in_array(auth()->user()->status , $user_status) ){
        Auth::logout();
        return redirect()->route('login');
    }
    return $next($request);
}
}


