<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Locale {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        $locale = config('app.defaultLocale');
        if (in_array($request->segment(1), config('app.locales'))) {
            $locale = $request->segment(1);
        }

        if ($request->routeIs('login', 'register', 'password.request') or ($request->segment(1) == 'account')) {
            if (!session()->has('locale')) {
                $locale = config('app.defaultLocale');
            } else $locale = session()->get('locale');
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        return $next($request);
    }
}
