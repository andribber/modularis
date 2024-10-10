<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next): JsonResponse|Response
    {
        try {
            $request->headers->set('Accept', 'application/json');

            return $next($request);
        } catch (Exception) {
        }
    }
}
