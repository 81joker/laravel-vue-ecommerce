<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestOrVerified extends EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , string $redirectToRoute = null): Response
    {
        if(!$request->user()){
            return $next($request);
        }
        return parent::handle($request, $next, $redirectToRoute);
        // if(!$request->user() && $request->user()->hasVerifiedEmail()){
        //     return $next($request);
        // }
    }
}
