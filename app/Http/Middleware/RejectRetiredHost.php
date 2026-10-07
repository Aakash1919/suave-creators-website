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

        if ($host === '' || $retired === [] || ! $this->isRetiredHost($host, $retired)) {
            return $next($request);
        }

        return response('Gone', 410)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    /**
     * Match apex and www variants (e.g. www.backend.suavecreators.com).
     *
     * @param  list<string>  $retired
     */
    private function isRetiredHost(string $host, array $retired): bool
    {
        if (in_array($host, $retired, true)) {
            return true;
        }

        if (str_starts_with($host, 'www.') && in_array(substr($host, 4), $retired, true)) {
            return true;
        }

        return false;
    }
}
