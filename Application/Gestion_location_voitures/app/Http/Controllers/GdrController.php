<?php

namespace App\Http\Controllers;

use App\Enum\VehiculeStatutEnum;
use App\Models\Vehicule;
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
        // faire la recherche sur l'index avec les parametres non obligatoire "?"
        $vehicules = Vehicule::whereNotIn('statut', [VehiculeStatutEnum::HORSU,VehiculeStatutEnum::LOUER])
                            ->get();

        return view('app.gestion_des_reservations')
                ->with('vehicules', $vehicules ?? null);
    }

    public function reserverVehicule(Request $request)
    {
        # code...
    }
}
