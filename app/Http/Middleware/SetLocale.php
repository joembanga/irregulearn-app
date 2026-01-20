<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if ($locale && in_array($locale, ['en', 'fr'])) {
            session(['locale' => $locale]);
        } else {
            $locale = session('locale', config('app.locale', 'en'));
            $request->route()->setParameter('locale', $locale);
        }

        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);

        // Forget the locale parameter so it's not passed to controllers if it was in the route
        if ($request->route() && $request->route()->hasParameter('locale')) {
            $request->route()->forgetParameter('locale');
        }

        return $next($request);
    }
}
