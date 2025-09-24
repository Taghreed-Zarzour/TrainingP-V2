<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->token()->expires_at < now()) {
            return response()->json([
                'msg' => 'انتهت صلاحية الجلسة، يرجى تسجيل الدخول مرة أخرى.',
                'success' => false
            ], 401);
        }
        return $next($request);
    }
}
