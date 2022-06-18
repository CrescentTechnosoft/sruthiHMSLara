<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthUser
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $page = null)
    {
        $session = $request->session();
        if (! $session->has('logged_in')) {
            return response('Login to Continue', 401, [
                'Content-Type' => 'text/plain'
            ]);
        } elseif (! is_null($page) && ! in_array($page, json_decode($session->get('user_access')))) {
            return \response('Unauthorized Access', 401, [
                'Content-Type' => 'text/plain'
            ]);
        } else {
            return $next($request);
        }
    }
}
