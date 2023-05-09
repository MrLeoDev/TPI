<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Location;
use App\Models\Vehicule;
use App\Enum\UserCategorieEnum;
use App\Enum\VehiculeStatutEnum;
use Illuminate\Support\Facades\Storage;

test('[UPDATE/STATUT VEHICULE] : Les gestionnaires peuvent changer le statut d\'un vehicule une fois la fin de la location et non avant', function () {

    // Variables importante
    $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
    $client = User::factory()->state(['categorie' => UserCategorieEnum::CLIENT])->create();
    Marque::factory()->create();
    Modele::factory()->create();
    $statut = VehiculeStatutEnum::cases()[rand(0,2)]->value;
    $vehicule = Vehicule::factory()->state(['statut' => VehiculeStatutEnum::LOUER])->create();
    $dureeL = rand(1,200);

    // Faire une date de location echue et non echue
    $currentTime = Carbon::now();
    $calculTime = now()->parse($currentTime)->addDays($dureeL);
    $finDeLaLocation = date('Y-m-d',strtotime($calculTime->addDay()));
    $avantFinDeLaLocation = date('Y-m-d',strtotime($calculTime->subDays(2)));

    // On doit faire en sorte que la date actuelle est superieur d'un jour que la location "Session('currentDate')"
    // Prepare la requete
    $changeCurrentDate = array (
        'currentDate' => $finDeLaLocation
    );

    $response = $this
        ->actingAs($gestionnaire)
        ->post(route('TdB.changeCurrentDate', $changeCurrentDate));

    // On doit cree la location de la voiture
    $bookCar = array(
        'duree_location'    => $dureeL,
        'client_id'         => $client->id,
        'vehicule_id'       => $vehicule->id,
    );

    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('GdR.bookCar'), $bookCar);

    $location = Location::where('vehicule_id', $vehicule->id)->first();

    // On tester le changement de statut post date
    // Prepare la requete
    $updateVehicule = array (
        'id_vehicule' => $vehicule->id,
        'statut' => $statut,
    );

    // On envoie la requete par le gestionnaire
    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('TdB.updateStatut', $updateVehicule));

    // Résultat
    // On recupere le vehicule mis a jours normalement
    $vehiculeU = Vehicule::find($vehicule->id);
    // On verifie que le statut est bien a jour
    $this->assertEquals($statut, $vehiculeU->statut);
    // On s'assure que le contrat est supprimer
    $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    // On s'assure de la code HTTP est bon
    $response->assertStatus(200);

    /**
     * Ne peut pas changer avant la fin du contrat
     */

    // On doit faire en sorte que la date actuelle est superieur d'un jour que la location "Session('currentDate')"
    // Prepare la requete
    $changeCurrentDate = array (
        'currentDate' => $avantFinDeLaLocation
    );

    $response = $this
        ->actingAs($gestionnaire)
        ->post(route('TdB.changeCurrentDate', $changeCurrentDate));

    // On doit cree la location de la voiture
    $bookCar = array(
        'duree_location'    => $dureeL,
        'client_id'         => $client->id,
        'vehicule_id'       => $vehicule->id,
    );

    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('GdR.bookCar'), $bookCar);

    $location = Location::where('vehicule_id', $vehicule->id)->first();

    // On tester le changement de statut avant date de fin de location
    // Prepare la requete
    $updateVehicule = array (
        'id_vehicule' => $vehicule->id,
        'statut' => $statut,
    );

    // On envoie la requete par le gestionnaire
    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('TdB.updateStatut', $updateVehicule));

    // Résultat
    // On recupere le vehicule mis a jours normalement
    $vehiculeU2 = Vehicule::find($vehicule->id);
    // On verifie que le statut est bien a jour
    $this->assertEquals(VehiculeStatutEnum::LOUER->value, $vehiculeU2->statut);
    // On s'assure que le contrat est supprimer
    $this->assertEquals($vehiculeU2->id, $location->vehicule_id);
    // On s'assure de la code HTTP est bon
    $response->assertStatus(200);

    // On supprimer l'image test
    Storage::disk('public')->delete($vehiculeU->image);
});
