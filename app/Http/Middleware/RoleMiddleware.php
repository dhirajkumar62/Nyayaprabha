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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // First check JWT API guard, then check session variables since it's a mixed legacy app
        $userRole = 'user'; // Default

        if (\Illuminate\Support\Facades\Auth::guard('api')->check()) {
            $userRole = \Illuminate\Support\Facades\Auth::guard('api')->user()->role ?? 'user';
        } else if ($request->session()->has('alogin')) {
            $userRole = 'admin'; // Legacy admin session
        } else if ($request->session()->has('login')) {
            $user = \Illuminate\Support\Facades\DB::table('users')->where('id', $request->session()->get('id'))->first();
            $userRole = $user->role ?? 'user';
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($userRole !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden. Insufficient permissions.'], 403);
            }
            abort(403, 'Forbidden. Insufficient permissions.');
        }

        return $next($request);
    }
}
