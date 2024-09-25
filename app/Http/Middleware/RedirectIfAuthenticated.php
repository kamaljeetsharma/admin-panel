<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Redirect to a route other than login
            return redirect()->route('dashboard'); // Adjust 'dashboard' to your actual route name
        }

        // Continue to the requested route if the user is not authenticated
        return $next($request);
    }
}
