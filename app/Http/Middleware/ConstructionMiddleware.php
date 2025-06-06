<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConstructionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('local') && ! session('passcode_authenticated')) {
            if (! $request->routeIs('under-construction') && ! $request->routeIs('under-construction.submit')) {
                return redirect()->route('under-construction');
            }
        }

        return $next($request);
    }
}
