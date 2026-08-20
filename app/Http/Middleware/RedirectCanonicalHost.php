<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectCanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $canonicalHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        if (! is_string($canonicalHost) || $canonicalHost === '') {
            return $next($request);
        }

        $requestHost = strtolower($request->getHost());
        $canonicalHost = strtolower($canonicalHost);

        if ($requestHost !== 'www.'.$canonicalHost) {
            return $next($request);
        }

        return redirect()->away(
            rtrim((string) config('app.url'), '/').$request->getRequestUri(),
            301
        );
    }
}
