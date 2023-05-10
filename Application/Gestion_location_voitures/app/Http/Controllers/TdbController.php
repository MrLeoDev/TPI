<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Vehicule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enum\VehiculeStatutEnum;

class TdbController extends Controller
{
    /**
     * On retourne la page Tableau de bord
     *
     * @return \Illuminate\Contracts\View\View returned
     */
    public function index()
    {
        $vehicules = Vehicule::where('statut', VehiculeStatutEnum::LOUER)
                            ->get();
        $locations = Location::all();

        $nbVoituresFlotte = Vehicule::count();
        $nbVoituresLoues = Vehicule::where('statut', VehiculeStatutEnum::LOUER)->count();

        // dd($nbVoituresLoues , $nbVoituresFlotte);
        if ($nbVoituresLoues == 0)
        {
            $rapport = 0;
        }
        else {
            $rapport = (($nbVoituresLoues / $nbVoituresFlotte) * 100);
        }

        return view('app.tableau_de_bord')
                ->with('vehicules', $vehicules ?? null)
                ->with('locations', $locations ?? null)
                ->with('nbVoituresFlotte', $nbVoituresFlotte ?? null)
                ->with('nbVoituresLoues', $nbVoituresLoues ?? null)
                ->with('rapport', round($rapport,0) ?? null);
    }

    public function updateStatut(Request $request)
    {
        // On verifie la requete
        $request->validate([
            'id_vehicule'       => ['required', 'exists:vehicules,id'],
            'statut'            => ['required', Rule::in(VehiculeStatutEnum::DISPO->value,VehiculeStatutEnum::REVISION->value,VehiculeStatutEnum::HORSU->value)],
        ]);

        try {
            $vehiculeLouer = Vehicule::findOrFail($request->id_vehicule);
            $location = Location::where('vehicule_id',$request->id_vehicule)->firstOrFail();
            throw_if((session('currentDate') ?? now()) <= $location->date_fin, new Exception('En dessous de la date de fin'));
        } catch (\Throwable $th) {

            // On recupere apres le rafraichissement de la page
            session()->flash('statutErreur', 'Une erreur est survenue...');
            return response()->json(['erreur' => 'Une erreur est survenue...']);
        }

        // On met a jour le statut du vehicule
        $vehiculeLouer->statut = $request->statut;
        $vehiculeLouer->save();

        // Supprimer la location
        $location->delete();

        // On recupere apres le rafraichissement de la page
        session()->flash('statutCar', 'Statut mis a jour!');

        // On retourne la promesse
        return response()->json(['success' => 'Statut mis a jour!']);
    }

    /**
     * Uniquement pour tester la fonctionnalite de la location
     *
     * @param Request $request
     * @return void
     */
    public function changeCurrentDate(Request $request)
    {
        // On verifie la requete
        $request->validate([
            'currentDate'       => ['required', 'date'],
        ]);
        session(['currentDate' => $request->currentDate]);
        return response()->json(['success' => 'Date à jours']);
    }
}
