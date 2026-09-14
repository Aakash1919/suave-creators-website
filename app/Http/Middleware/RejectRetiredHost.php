<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RejectRetiredHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = strtolower($request->getHost());
        $retired = array_map('strtolower', (array) config('seo.retired_hosts', []));

        if ($host === '' || $retired === [] || ! in_array($host, $retired, true)) {
            return $next($request);
        }

        return response('Gone', 410)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
