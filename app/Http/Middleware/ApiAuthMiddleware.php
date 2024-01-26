<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    const HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;

    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $tokenWithBearer = $request->header('Authorization');

        $token = substr($tokenWithBearer, 7);
        $token = $request->bearerToken();

        if (isset($token) && !empty($token)) {
            $tokencheck = getApiTokenCheck($token);

            if (isset($tokencheck) && !empty($tokencheck)) {
                return $next($request);
            }
        }

        return response()->json(["message" => "Unauthenticated"], self::HTTP_UNAUTHORIZED);
    }
}
