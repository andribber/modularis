<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    public function handle(Request $request, Closure $next): JsonResponse|Response
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'PUT, POST, DELETE, GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Accept, Authorization, Content-Type');
    }
}
