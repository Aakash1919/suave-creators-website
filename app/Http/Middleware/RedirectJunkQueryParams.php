<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectJunkQueryParams
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->method(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        if ($request->is('admin', 'admin/*', 'suave-agent', 'suave-agent/*', 'up')) {
            return $next($request);
        }

        $query = $request->query();
        if ($query === []) {
            return $next($request);
        }

        $allowedKeys = array_fill_keys(
            array_map('strval', (array) config('seo.allowed_query_params', [])),
            true
        );

        $kept = [];
        $hasJunk = false;

        foreach ($query as $key => $value) {
            $name = (string) $key;
            if (isset($allowedKeys[$name])) {
                $kept[$name] = $value;

                continue;
            }

            $hasJunk = true;
        }

        if (! $hasJunk) {
            return $next($request);
        }

        $target = $request->url();
        if ($kept !== []) {
            $target .= '?'.http_build_query($kept);
        }

        return redirect()->to($target, 301);
    }
}
