<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GdrController extends Controller
{
    /**
     * On retourne la page Gestion des reservations
     *
     * @return \Illuminate\Contracts\View\View returned
     */
    public function index()
    {
        return view('app.gestion_des_reservations');
    }
}
