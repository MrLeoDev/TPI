<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use App\Enum\UserCategorieEnum;
use App\Enum\VehiculeStatutEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GdrController extends Controller
{
    /**
     * On retourne la page Gestion des reservations
     *
     * @return \Illuminate\Contracts\View\View returned
     */
    public function index(Request $request)
    {
        if ($request->hasAny(['type','transmission']))
        {
            if (!empty($request->type))
            {
                if (!empty($request->transmission))
                {
                    $vehicules = Vehicule::where([
                        ['type', $request->type],
                        ['transmission', $request->transmission]
                        ])->whereNotIn('statut', [VehiculeStatutEnum::REVISION,VehiculeStatutEnum::HORSU,VehiculeStatutEnum::LOUER])
                        ->get();
                }
                else
                {
                    $vehicules = Vehicule::where('type', $request->type)
                                        ->whereNotIn('statut', [VehiculeStatutEnum::REVISION,VehiculeStatutEnum::HORSU,VehiculeStatutEnum::LOUER])
                                        ->get();
                }
            }
            else
            {
                if (!empty($request->transmission))
                {
                    $vehicules = Vehicule::where('transmission', $request->transmission)
                                        ->whereNotIn('statut', [VehiculeStatutEnum::REVISION,VehiculeStatutEnum::HORSU,VehiculeStatutEnum::LOUER])
                                        ->get();
                }
                else
                {
                    $vehicules = Vehicule::whereNotIn('statut', [VehiculeStatutEnum::REVISION,VehiculeStatutEnum::HORSU,VehiculeStatutEnum::LOUER])
                                        ->get();
                }
            }
            session()->flashInput($request->input());
        }
        else
        {
            $vehicules = Vehicule::whereNotIn('statut', [VehiculeStatutEnum::REVISION,VehiculeStatutEnum::HORSU,VehiculeStatutEnum::LOUER])
                                ->get();
        }

        // Recuperer les clients
        if (Auth::user()->categorie->value == UserCategorieEnum::GESTION->value)
        {
            $clients = User::where('categorie', UserCategorieEnum::CLIENT)
                            ->orderBy('prenom', 'ASC')
                            ->get();
        }

        return view('app.gestion_des_reservations')
                ->with('vehicules', $vehicules ?? null)
                ->with('clients', $clients ?? null);
    }

    public function bookCar(Request $request)
    {
        // On valide les donnees selon la categorie de l'utilisateur
        if (Auth::user()->categorie->value == UserCategorieEnum::GESTION->value)
        {
            $request->validate([
                'duree_location'    => ['required', 'numeric', 'min:1'],
                'client_id'         => ['required', 'exists:users,id'],
                'vehicule_id'       => ['required', 'exists:vehicules,id'],
            ]);
        }
        else {
            $request->validate([
                'duree_location'    => ['required', 'numeric', 'min:1'],
                'vehicule_id'       => ['required', 'exists:vehicules,id'],
            ]);
        }

        // Calculer la periode de reservation
        $duree_location = $request->duree_location;
        $currentTime = Carbon::now();
        $calculTime = now()->parse($currentTime)->addDays($duree_location);
        $dateDebut = date(date('Y-m-d',strtotime($currentTime)));
        $dateFin = date('Y-m-d',strtotime($calculTime));

        // Creation de la reservation
        $location = new Location();
        $location->vehicule_id = $request->vehicule_id;
        $location->client_id = $request->client_id ?? Auth::user()->id;
        $location->date_debut = $dateDebut;
        $location->date_fin = $dateFin;

        // Mettre a jour le statut du vehicule en louer
        $vehiculeLouer = Vehicule::find($request->vehicule_id);
        $vehiculeLouer->statut = VehiculeStatutEnum::LOUER;

        // Calcul du montant du client
        # Variables importante
        $prixSansReduction = $duree_location*$vehiculeLouer->tarif_journalier;
        $pourcentageSemaine = 10/100;
        $pourcentageMois    = 20/100;

        // On regarde si une reduction s'applique avant le prix final
        if ($duree_location >= 7)
        {
            if ($duree_location >= 30)
            {
                $prixLocation = (($prixSansReduction) - (($prixSansReduction) * ($pourcentageMois)));
            }
            else {
               $prixLocation = (($prixSansReduction) - (($prixSansReduction) * ($pourcentageSemaine)));
            }
        }
        else {
            $prixLocation = $prixSansReduction;
        }

        // Mettre a jour le montant du client
        $client = User::find($request->client_id ?? Auth::user()->id);
        $client->montant_des_locations = $client->montant_des_locations + $prixLocation;

        // On sauvegarde le tout dans la base de donnees
        $location->save();
        $vehiculeLouer->save();
        $client->save();

        return back()->with('statutLocation', 'Reservation reussit!');
    }
}
