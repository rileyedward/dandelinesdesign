<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldSkipTracking($request)) {
            return $next($request);
        }

        $sessionId = $request->session()->get('page_view_session_id');

        if (! $sessionId) {
            $sessionId = Str::uuid()->toString();
            $request->session()->put('page_view_session_id', $sessionId);
        }

        $pageView = PageView::query()->updateOrCreate(
            ['session_id' => $sessionId],
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'referrer' => $request->header('referer'),
            ]
        );

        logger()->info('Page view tracked ' . $pageView->id);

        return $next($request);
    }

    private function shouldSkipTracking(Request $request): bool
    {
        return $request->is('api/*') ||
               $request->is('admin/*') ||
               $request->is('_debugbar/*') ||
               $request->ajax() ||
               $request->expectsJson();
    }
}
