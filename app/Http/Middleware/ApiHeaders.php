<?php

namespace App\Http\Middleware;

use Closure;

class ApiHeaders
{
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        // إضافة Headers للاستجابة
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
