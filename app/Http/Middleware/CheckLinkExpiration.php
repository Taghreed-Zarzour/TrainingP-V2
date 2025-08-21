<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class CheckLinkExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // تحقق مما إذا كانت صلاحية الرابط قد انتهت
        if ($request->routeIs('complete-trainer-register') || 
            $request->routeIs('complete-trainee-register') || 
            $request->routeIs('complete-assistant-register') || 
            $request->routeIs('complete-organization-register')) {

            // تحقق من صلاحية الرابط
            if (!URL::hasValidSignature($request)) {
                return redirect()->route('link.expired'); // توجيه إلى صفحة انتهاء صلاحية الرابط
            }
        }

        return $next($request);
    }
}
