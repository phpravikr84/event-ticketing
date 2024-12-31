<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  Role name to check
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Retrieve the role from the database
        $roleModel = \App\Models\Role::where('name', $role)->first();

        // Ensure the role exists
        if (!$roleModel) {
            return redirect()->route('login')->with('error', 'Invalid role. Access denied.');
        }

        // Check if the authenticated user has the required role
        if (Auth::user()->role_id !== $roleModel->id) {
            return redirect()->route('login')->with('error', 'Access denied. Unauthorized.');
        }

        // Allow the request to proceed
        return $next($request);
    }
}
