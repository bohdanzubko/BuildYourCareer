<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (count($roles) === 1) {
            $roles = explode(',', $roles[0]);
            $roles = array_map('trim', $roles);
        }

        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Доступ заборонено');
        }

        return $next($request);
    }
}
