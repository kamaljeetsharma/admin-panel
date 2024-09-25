<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switchLang($locale)
    {//dd($request->all());
        
        if (in_array($locale, ['en', 'fr', 'es', 'de'])) { 
            Session::put('locale', $locale);
            //dd(Session::has('locale'));
        }

        return Redirect::back();
    }
}


