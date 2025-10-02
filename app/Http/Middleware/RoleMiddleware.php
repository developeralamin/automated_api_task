<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
 public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Unauthorized. Please login first.'
            ], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Forbidden. You do not have access.'
            ], 403);
        }

        return $next($request);
    }
}
