<?php

namespace PragmaRX\Google2FALaravel;

use Closure;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class MiddlewareStateless
{
    public function handle($request, Closure $next)
    {
        $authenticator = app(Authenticator::class)->bootStateless($request);

        $request->session()->put('redirectTo', url()->current());

        if ($authenticator->isAuthenticated()) {
            return $next($request);
        }

        return $authenticator->makeRequestOneTimePasswordResponse();
    }
}
