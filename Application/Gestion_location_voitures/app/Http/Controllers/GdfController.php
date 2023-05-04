<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GdfController extends Controller
{
    /**
     * On retourne la page Gestion de la flotte
     *
     * @return \Illuminate\Contracts\View\View returned
     */
    public function index()
    {
        return view('app.gestion_de_la_flotte');
    }
}
