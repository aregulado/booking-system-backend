<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequestPerformance
{
    public function handle(Request $request, Closure $next): Response
    {
        // Record request start time
        $startTime = microtime(true);

        // Process the request
        $response = $next($request);

        // Calculate execution time
        $executionTime = microtime(true) - $startTime;

        // Log the request performance
        Log::channel('performance')->info('Request Performance', [
            'uri' => $request->getUri(),
            'method' => $request->method(),
            'execution_time' => $executionTime,
            'status_code' => $response->getStatusCode(),
        ]);

        return $response;
    }
}
