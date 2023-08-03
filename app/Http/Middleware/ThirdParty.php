<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ThirdParty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $thirdPartyToken = 'Bearer ' . config('security.third_party_token');
        if ($request->header('Authorization') == $thirdPartyToken) {
            return $next($request);
        } else
            return response()->json(['success' => false, 'message' => 'Üçüncü tərəf API bağlantısı üçün token daxil etməlisiniz!'], 401);
    }
}
