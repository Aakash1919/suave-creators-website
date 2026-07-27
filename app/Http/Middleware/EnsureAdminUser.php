<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminUser
{
    /**
     * Require a signed-in user before accessing admin routes (roles gate features).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()
                ->route('admin.login')
                ->withErrors(['email' => 'Please sign in to continue.']);
        }

        return $next($request);
    }
}
