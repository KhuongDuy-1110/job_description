<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BeforeApi
{
    const IGNORE_LIST_API = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->startRequestTime = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $request->endRequestTime = microtime(true);
        if (!in_array($request['REQUEST_URI'], self::IGNORE_LIST_API)) {
            $this->log($request, $response);
        }
    }

    protected function log($request, $response)
    {
        $duration = $request->endRequestTime - $request->startRequestTime;
        $url = $request->fullUrl();
        $method = $request->getMethod();
        $ip = $request->getClientIp();
        $log = "{$ip}: {$method}@{$url} \n".
        "Request duration: {$duration}ms \n" .
        "Request params: ".json_encode($request->all())." \n".
        "Response : {$response->getContent()} \n";
        \Log::channel('requestapi')->info($log);
    }
}
