<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$types): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Grant full access to admin users
        if ($user->type === 'admin') {
            return $next($request);
        }

        // Check if user type matches one of the allowed types
        if (in_array($user->type, $types)) {
            return $next($request);
        }

        // Redirect unauthorized users
        return redirect()->route('login')->with('error', 'Access Denied.');
    }
}
