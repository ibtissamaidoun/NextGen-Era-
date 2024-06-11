<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PassNonceToViews
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $nonce = $response->headers->get('Csp-Nonce');
        view()->share('nonce', $nonce);
        return $response;
    }
}
