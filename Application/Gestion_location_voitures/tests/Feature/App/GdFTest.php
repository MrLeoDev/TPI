<?php

use App\Models\User;
use App\Enum\VehiculeTypeEnum;
use App\Enum\UserCategorieEnum;
use App\Enum\VehiculeStatutEnum;
use Illuminate\Http\UploadedFile;
use App\Enum\VehiculeTransmissionEnum;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Storage;

/**
 * Gestionnaire
 */
test('[AJOUTER VEHICULE] : Les gestionnaires peuvent ajouter un véhicule', function () {

    // Variables importante
    $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
    $type = VehiculeTypeEnum::cases()[rand(0,3)]->value;
    $statut = VehiculeStatutEnum::cases()[rand(0,2)]->value;
    $transmission = VehiculeTransmissionEnum::cases()[rand(0,1)]->value;
    Storage::fake('voitureImg');

    // On crée un faux formulaire
    $vehiculeAdd = array (
        'vehicule_image' => UploadedFile::fake()->image('voitureImg.jpg') ,
        'id'=> 'CH 999 999',
        'tarifj' => '11.11',
        'marque' => 'Test',
        'modele' => 'T2' ,
        'type'=> $type,
        'statut' => $statut,
        'transmission' => $transmission
    );

    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('GdF.addCar'), $vehiculeAdd);

    /**
     *  Résultat
     */
    // On récupère le véhicule crée
    $vehicule = Vehicule::where('id', $vehiculeAdd['id'])->first();

    // On s'assure que l'image est bien enregistrer au bon endroit
    Storage::disk('public')->assertExists($vehicule->image);

    // Résultat
    $this->assertEquals('CH 999 999', $vehicule->id);
    $this->assertEquals('11.11', $vehicule->tarif_journalier);
    $this->assertEquals('Test', $vehicule->marque->libelle);
    $this->assertEquals('T2', $vehicule->modele->libelle);
    $this->assertEquals($type, $vehicule->type);
    $this->assertEquals($statut, $vehicule->statut);
    $this->assertEquals($transmission, $vehicule->transmission);
    $response->assertStatus(302);

    // On supprimer l'image test
    Storage::disk('public')->delete($vehicule->image);
});

test('[SUPPRIMER VEHICULE] : Les gestionnaires peuvent supprimer un véhicule', function () {
    $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
    Marque::factory()->create();
    Modele::factory()->create();
    $vehicule = Vehicule::factory()->create();

    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('GdF.deleteCar', $vehicule->id));

    // Résultat

    // On regarde si l'image est bien supprimer
    Storage::disk('public')->assertMissing($vehicule->image);
    $this->assertDatabaseMissing('vehicules', ['id' => $vehicule->id]);
    $response->assertStatus(302);
});

test('[UPDATE/STATUT VEHICULE] : Les gestionnaires peuvent mettre à jour le statut d\'un véhicule', function () {

    // Variables importante
    $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
    Marque::factory()->create();
    Modele::factory()->create();
    $statut = VehiculeStatutEnum::cases()[rand(0,2)]->value;
    $vehicule = Vehicule::factory()->create();

    // Prepare la requete
    $updateVehicule = array (
        'id_vehicule' => $vehicule->id,
        'statut' => $statut,
    );


    // On envoie la requete par le gestionnaire
    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('GdF.updateStatut', $updateVehicule));

    // Résultat
    // On recupere le vehicule mis a jours normalement
    $vehiculeU = Vehicule::find($vehicule->id);
    // On verifie que le statut est bien a jour
    $this->assertEquals($statut, $vehiculeU->statut);
    $response->assertJson(['success' => 'Statut mis a jour!']);
    $response->assertStatus(200);

    // On supprimer l'image test
    Storage::disk('public')->delete($vehiculeU->image);
});

