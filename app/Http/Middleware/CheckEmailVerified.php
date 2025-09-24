<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
            Auth::logout(); // Log out the user
            return redirect()->route('verify-user', ['id' => Auth::user()->id])
                             ->with('message', 'يرجى التحقق من بريدك الإلكتروني.');
        }

        return $next($request);
    }
}
