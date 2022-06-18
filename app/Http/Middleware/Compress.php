<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Compress
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        return response(\gzcompress($response->getContent()), 200, [
            'Content-Encoding' => 'deflate',
            'Content-Type' => 'application/json',
        ]);
    }
}
