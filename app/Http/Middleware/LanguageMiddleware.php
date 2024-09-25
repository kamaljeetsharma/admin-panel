<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the session has a language set
        if (Session::has('locale')) {
           // dd('vgjkj');
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
