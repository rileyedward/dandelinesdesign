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
            if (! $request->routeIs('under-construction.index') && ! $request->routeIs('under-construction.store')) {
                return redirect()->route('under-construction.index');
            }
        }

        return $next($request);
    }
}
