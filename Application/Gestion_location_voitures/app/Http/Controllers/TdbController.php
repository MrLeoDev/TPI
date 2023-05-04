<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TdbController extends Controller
{
    /**
     * On retourne la page Tableau de bord
     *
     * @return \Illuminate\Contracts\View\View returned
     */
    public function index()
    {
        return view('app.tableau_de_bord');
    }
}
