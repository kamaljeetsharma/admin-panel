<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role = null)
{
    // Check if the user is logged in
    if (Auth::check()) {
        // Allow access to both 'admin' and 'customer' for specific shared pages
        if (!Auth::user()->role == $role || Auth::user()->role == 'admin') {
            return $next($request);
        }
        
        // Allow access to 'customer' role for specific pages
        if (Auth::user()->role == 'customer' && $role == 'customer') {
            return $next($request);
        }
    }

    // Redirect to login page if user is not authenticated or doesn't have the right role
    return redirect()->back()->withErrors(['message' => 'You do not have permission to access this page.']);
    //return redirect()->route('login');
}

}