<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Location;
use App\Models\Vehicule;
use App\Enum\UserCategorieEnum;
use App\Enum\VehiculeStatutEnum;

test('[RESERVATION VEHICULE] : Les gestionnaires / clients peuvent réserver un véhicules.', function () {

    // Variables importants
    $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
    $clientGestion = User::factory()->state(['categorie' => UserCategorieEnum::CLIENT, 'montant_des_locations' => 0])->create();
    Marque::factory()->create();
    Modele::factory()->create();
    $vehiculeGestion = Vehicule::factory()->state(['statut' => VehiculeStatutEnum::DISPO, 'tarif_journalier' => '10.00'])->create();
    $dureeL = rand(1,200);

    // Calcule de la duree
    $currentTime = Carbon::now();
    $calculTime = now()->parse($currentTime)->addDays($dureeL);
    $dateDebut = date(date('Y-m-d',strtotime($currentTime)));
    $dateFin = date('Y-m-d',strtotime($calculTime));

    // Calcul du montant du client
    # Variables importante
    $prixSansReduction = $dureeL*$vehiculeGestion->tarif_journalier;
    $pourcentageSemaine = 10/100;
    $pourcentageMois    = 20/100;

    // On regarde si une reduction s'applique avant le prix final
    if ($dureeL >= 7)
    {
        if ($dureeL >= 30)
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

    $bookCarGestion = array (
        'duree_location'    => $dureeL,
        'client_id'         => $clientGestion->id,
        'vehicule_id'       => $vehiculeGestion->id,
    );

    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('GdR.bookCar'), $bookCarGestion);

    // On recupere les donnees a jours
    $vehiculeGestionBook = Vehicule::find($vehiculeGestion->id);
    $clientGestionM = User::find($clientGestion->id);
    $location = Location::where('vehicule_id', $vehiculeGestionBook->id)->first();

    // Resultat
    $this->assertEquals($clientGestionM->id, $location->client_id);
    $this->assertEquals($vehiculeGestionBook->id, $location->vehicule_id);
    $this->assertEquals($dateDebut, $location->date_debut);
    $this->assertEquals($dateFin, $location->date_fin);
    $this->assertEquals(VehiculeStatutEnum::LOUER->value, $vehiculeGestionBook->statut);
    $this->assertEquals($prixLocation, $clientGestionM->montant_des_locations);
    $response->assertStatus(302);

    // Le client effectue sa reservation
    $client = User::factory()->state(['categorie' => UserCategorieEnum::CLIENT, 'montant_des_locations' => 0])->create();
    $vehiculeClient = Vehicule::factory()->state(['statut' => VehiculeStatutEnum::DISPO, 'tarif_journalier' => '10.00'])->create();

    $bookCarClient = array (
        'duree_location'    => $dureeL,
        'vehicule_id'       => $vehiculeClient->id,
    );

    $response = $this
        ->actingAs($client)
        ->post(route('GdR.bookCar'), $bookCarClient);

        // On recupere les donnees a jours
        $vehiculeClientBook = Vehicule::find($vehiculeClient->id);
        $clientM = User::find($client->id);
        $location = Location::where('vehicule_id', $vehiculeClientBook->id)->first();

        // Resultat
        $this->assertEquals($clientM->id, $location->client_id);
        $this->assertEquals($vehiculeClientBook->id, $location->vehicule_id);
        $this->assertEquals($dateDebut, $location->date_debut);
        $this->assertEquals($dateFin, $location->date_fin);
        $this->assertEquals(VehiculeStatutEnum::LOUER->value, $vehiculeClientBook->statut);
        $this->assertEquals($prixLocation, $clientM->montant_des_locations);
        $response->assertStatus(302);
});
