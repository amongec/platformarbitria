<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLanguage(Request $request): RedirectResponse
    {

        // setCurrentLanguage();
        //return $next($request);

        
        setLanguageSession($request->route('language'));

        return back();
    }
}