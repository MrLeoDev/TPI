<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CmcController extends Controller
{
    /**
     * On retourne la page Creation / Modification de comptes
     *
     * @return \Illuminate\Contracts\View\View returned
     */
    public function index()
    {
        return view('app.creation_modification_comptes');
    }
}
