<?php

use App\Models\User;
use App\Enum\VehiculeTypeEnum;
use App\Enum\UserCategorieEnum;
use App\Enum\VehiculeStatutEnum;
use Illuminate\Http\UploadedFile;
use App\Enum\VehiculeTransmissionEnum;
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
});

test('[SUPPRIMER VEHICULE] : Les gestionnaires peuvent supprimer un véhicule', function () {
    $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
    $compte = User::factory()->create();

    $response = $this
         ->actingAs($gestionnaire)
         ->post(route('CMC.delete', $compte->id));

    // Résultat
    $this->assertDatabaseMissing('users', ['id' => $compte->id]);
    $response->assertStatus(302);
});
