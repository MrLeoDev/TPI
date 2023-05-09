<?php

use App\Http\Controllers\CmcController;
use App\Http\Controllers\GdfController;
use App\Http\Controllers\GdrController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TdbController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| C'est ici que vous pouvez enregistrer des routes web pour votre application.
| Ces routes sont chargées par le RouteServiceProvider et toutes seront affectées au groupe d'intergiciels "web".
|
*/

/**
 * Changement de langue à tout instant
 */
Route::get('lang/', [LangController::class, 'change'])->name('changeLang');

/**
 * Seulement pour les invités
 */
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

/**
 * Seulement pour les utilisateurs
 */
Route::middleware('auth')->group(function () {

    /**
     * Creation / Modification de comptes
     */

    // Accès : Tous les utilisateurs
    # Accès à la page
    Route::get('/creation_modification_comptes', [CmcController::class, 'index'])
        ->name('CMC');

    # Mise à jour du mot de passe
    Route::post('/creation_modification_comptes/update',[CmcController::class, 'update'])
        ->name('CMC.update');

    // Accès : Administrateur
    # Mise à jour des informations personnelles
    Route::post('/creation_modification_comptes/updateInfoPerso', [CmcController::class, 'updateInfoPerso'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.updateInfoPerso');

    # Ajouter un utilisateur
    Route::post('/creation_modification_comptes',[CmcController::class, 'addUser'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.addUser');

    # Action AJAX via Modal : Afficher les informations d'un utilisateur
    Route::get('/creation_modification_comptes/showUser/{id}', [CmcController::class, 'showUpdateUser'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.showUpdateUser');

    # Modification des informations d'un utilisateur
    Route::post('/creation_modification_comptes/updateUser/{id}',[CmcController::class, 'updateUser'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.updateUser');

    # Supprimer un utilisateur
    Route::post('/creation_modification_comptes/{id}', [CmcController::class, 'delete'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.delete');

    /**
     * Gestion de la flotte
     */

    // Accès : Gestionnaire et Administrateur
    # Accès à la page
    Route::get('/gestion_de_la_flotte', [GdfController::class, 'index'])
        ->middleware('categorie:Gestionnaire,Administrateur')
        ->name('GdF');

    // Accès : Gestionnaire
    # Ajout d'un véhicule
    Route::post('/gestion_de_la_flotte/addCar', [GdfController::class, 'addCar'])
        ->middleware('categorie:Gestionnaire')
        ->name('GdF.addCar');

    # Supprimer un véhicule
    Route::post('/gestion_de_la_flotte/deleteCar/{id}', [GdfController::class, 'deleteCar'])
        ->middleware('categorie:Gestionnaire')
        ->name('GdF.deleteCar');

    # Mise à jour du statut du véhicule
    Route::post('/gestion_de_la_flotte/updateStatut', [GdfController::class, 'updateStatut'])
        ->middleware('categorie:Gestionnaire')
        ->name('GdF.updateStatut');

    /**
     * Gestion des reservations
     */

    // Accès : Client et Gestionnaire
    # Accès à la page
    Route::get('/gestion_des_reservation', [GdrController::class, 'index'])
        ->middleware('categorie:Client,Gestionnaire')
        ->name('GdR');

    # Louer un véhicule
    Route::post('/gestion_des_reservation/bookCar', [GdrController::class, 'bookCar'])
        ->middleware('categorie:Client,Gestionnaire')
        ->name('GdR.bookCar');

    /**
     * Tableau de bord
     */

    // Accès : Gestionnaire et Administrateur
    # Accès à la page
    Route::get('/tableau_de_bord', [TdbController::class, 'index'])
        ->middleware('categorie:Gestionnaire,Administrateur')
        ->name('TdB');

    # (Pour démonstration) : Changement de la date actuelle de l'application
    Route::post('/tableau_de_bord/changeCurrentDate', [TdbController::class, 'changeCurrentDate'])
        ->middleware('categorie:Gestionnaire,Administrateur')
        ->name('TdB.changeCurrentDate');

    // Accès : Gestionnaire
    # Mise à jour du statut du véhicule
    Route::post('/tableau_de_bord/updateStatut', [TdbController::class, 'updateStatut'])
        ->middleware('categorie:Gestionnaire')
        ->name('TdB.updateStatut');
});

/**
 * On inclut les routes concernant les accès d'authentification
 * Si le fichier ne s'inclut pas, l'application s'arrête
 */
require __DIR__.'/auth.php';
