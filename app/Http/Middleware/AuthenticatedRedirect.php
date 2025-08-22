<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //if logged in
        if (Auth::user()){

            // if the route url from searchBar are login or register
            if ($request->route()->getName() == 'login' || $request->route()->getName() == 'register'){
                if (Auth::user()->role === 'admin')
                {
                    return to_route('admin#dashboard');
                }elseif (Auth::user()->role === 'superadmin') {
                    return to_route('admin#dashboard');
                }
                 else {
                    return to_route('user#homePage');
                }
            }else{
                return $next($request);
            }
        }
        return $next($request);
    }
}
