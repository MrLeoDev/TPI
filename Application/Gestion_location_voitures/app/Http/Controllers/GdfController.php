<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use App\Models\Modele;
use App\Models\Location;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use App\Enum\VehiculeTypeEnum;
use App\Enum\UserCategorieEnum;
use Illuminate\Validation\Rule;
use App\Enum\VehiculeStatutEnum;
use Illuminate\Support\Facades\Auth;
use App\Enum\VehiculeTransmissionEnum;
use Illuminate\Support\Facades\Storage;

class GdfController extends Controller
{
    /**
     * On retourne la page Gestion de la flotte
     *
     * @return \Illuminate\Contracts\View\View returned
     */
    public function index()
    {
        if (Auth::user()->categorie->value == UserCategorieEnum::GESTION->value) {
            $marques = Marque::all();
            $modeles = Modele::all();
        }

        // Vue d'ensemble des véhicules
        $vehicules = Vehicule::orderByRaw("FIELD(statut , 'Disponible', 'En révision', 'Hors d’usage', 'Loué') ASC")
                                ->get();

        $locations = Location::all();
        return view('app.gestion_de_la_flotte')
                ->with('marques', $marques ?? null)
                ->with('modeles', $modeles ?? null)
                ->with('vehicules', $vehicules ?? null)
                ->with('locations', $locations ?? null);
    }

    /**
     * Ajouter une voiture
     *
     * @category Gestionnaire
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCar(Request $request)
    {
        $request->validate([
            'vehicule_image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id'                => ['required', 'string', 'max:255', 'unique:vehicules,id'],
            'tarifj'            => ['required', 'numeric'],
            'marque'            => ['required', 'string', 'max:255'],
            'modele'            => ['required', 'string', 'max:255'],
            'type'              => ['required', Rule::in(VehiculeTypeEnum::BERLINE->value,VehiculeTypeEnum::BREAK->value,VehiculeTypeEnum::SUV->value,VehiculeTypeEnum::MONOSPACE->value)],
            'statut'            => ['required', Rule::in(VehiculeStatutEnum::DISPO->value,VehiculeStatutEnum::REVISION->value,VehiculeStatutEnum::HORSU->value,VehiculeStatutEnum::LOUER->value)],
            'transmission'      => ['required', Rule::in(VehiculeTransmissionEnum::MANUEL->value,VehiculeTransmissionEnum::AUTO->value)],
        ]);

        // Trouver le modele et la marque sinon les crées pour la création du vehicule
        $marque = Marque::firstOrCreate(['libelle' => $request->marque]);
        $modele = Modele::firstOrCreate(['libelle' => $request->modele]);

        // On enregistre la nouvelle route ainsi que la nouvelle image
        $img_vehicule_path = $request->vehicule_image->store('img/vehicules', 'public');

        // Création de la voiture
        $vehicule = new Vehicule();
        $vehicule->id = $request->id;
        $vehicule->tarif_journalier = $request->tarifj;
        $vehicule->marque_id = $marque->id;
        $vehicule->modele_id = $modele->id;
        $vehicule->type = $request->type;
        $vehicule->statut = $request->statut;
        $vehicule->transmission = $request->transmission;
        $vehicule->image = $img_vehicule_path;
        $vehicule->save();

        return back()->with('statutAddCar', trans('gestion_de_la_flotte.statutAddCar'));
    }

    /**
     * Pouvoir supprimer un vehicule
     *
     * @category Gestionnaire
     * @param [int] $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCar($id)
    {
        // S'assure que la demande est faisable
        try {
            $vehicule = Vehicule::findOrFail($id);
        } catch (\Throwable $th)
        {
            return back()->with('statutErreur', trans('gestion_de_la_flotte.statutErreur'));
        }

        // On recupere le nom de l'utilisateur
        $identifiant = $vehicule->id;

        // On supprime l'image lier dans le storage
        if(Storage::exists('public/' . $vehicule->image))
        {
            Storage::delete('public/' . $vehicule->image);
        }

        // On supprime l'utilisateur
        $vehicule->delete();

        return back()->with('statutDeleteCar', trans('gestion_de_la_flotte.statutDeleteCar', ['car' => $identifiant]));
    }

    public function updateStatut(Request $request)
    {
        // On verifie la requete
        $request->validate([
            'id_vehicule'       => ['required', 'exists:vehicules,id'],
            'statut'            => ['required', Rule::in(VehiculeStatutEnum::DISPO->value,VehiculeStatutEnum::REVISION->value,VehiculeStatutEnum::HORSU->value,VehiculeStatutEnum::LOUER->value)],
        ]);
        try {
            $vehiculeLouer = Vehicule::findOrFail($request->id_vehicule);
        } catch (\Throwable $th) {
            return response()->json(['erreur' => 'Une erreur est survenue...']);
        }

        // On met a jour le statut du vehicule
        $vehiculeLouer->statut = $request->statut;
        $vehiculeLouer->save();

        // On recupere apres le rafraichissement de la page
        session()->flash('statutCar', 'Statut mis a jour!');

        // On retourne la promesse
        return response()->json(['success' => 'Statut mis a jour!']);
    }
}
