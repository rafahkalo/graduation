<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->is_verified != 1) {
            return response()->json([
                'message' => __('message.account_not_verified'),
            ], 403);
        }

        return $next($request);
    }
}
