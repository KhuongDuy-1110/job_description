<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AfterApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $data = $response->original ?? $response;
        if (isset($data['code'])) {
            $result = $data;
        } else {
            $result = [
                'success' => true,
                'code' => 200,
                'message' => 'Success'
            ];
            if (is_array($data)) {
                $result['data'] = $data;
            }
        }
        return Response::json($result, $result['code']);
    }
}
