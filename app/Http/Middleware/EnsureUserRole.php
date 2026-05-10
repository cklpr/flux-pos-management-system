<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = auth()->user();

        if (! $user || ! in_array($user->role, explode('|', $roles), true)) {
            abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }
}
