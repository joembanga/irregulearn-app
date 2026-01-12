<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);

        if (!in_array($locale, ['en', 'fr'])) {
            // Default to 'fr' if not valid or missing (though missing should be caught by route group, this handles failures)
            $default = 'en';
            
            // Check segments to see if we are already at root but somehow here?
            // Actually, if we use prefix routes, this middleware should be applied TO those routes.
            // If the URL is just '/' it won't hit the prefixed routes unless we handle it separately.
            
            // However, assuming this runs on prefixed routes:
            // return $next($request);
            // Wait, we need to SET the locale.
        }

        if (in_array($locale, ['en', 'fr'])) {
            app()->setLocale($locale);
            URL::defaults(['locale' => $locale]);
        }

        return $next($request);
    }
}
