<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    /**
     * Il retourne la langue souhaite par l'utilisateur
     *
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
        app()->setLocale($request->lang);
        session()->put('locale', $request->lang);
        return redirect()->back();
    }
}
