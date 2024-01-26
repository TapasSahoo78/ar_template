<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role, $permission = null): Response
    {
        $user = auth()->user();
        if (isset($user) && !empty($user)) {
            if (!$request->user()->hasRole($role)) {
                return abort(403, 'Unauthorized');
            }
        } else {
            $redirectRoute = ($role == 'user') ? 'user.login' : 'admin.login';
            return redirect()->route($redirectRoute);
        }

        if ($permission !== null && !$request->user()->can($permission)) {
            return abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
