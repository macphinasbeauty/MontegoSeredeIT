<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Check if user is admin (legacy support)
        if ($user->is_admin) {
            return $next($request);
        }

        // Check if user has the required role
        if ($user->role && $user->role->name === $role) {
            return $next($request);
        }

        // For agent role, also allow if they have an agent record
        if ($role === 'agent' && $user->role && $user->role->name === 'agent') {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'You do not have permission to access this area.');
    }
}
