<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route($this->getLoginPage($request));
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->wantsJson())
            throw new AuthenticationException();

        return redirect($this->getLoginPage($request));
    }

    private function getLoginPage(Request $request)
    {
        return $request->segment(1) != 'gopanel' ? RouteServiceProvider::LOGIN : RouteServiceProvider::GOPANEL_LOGIN;
    }
}
