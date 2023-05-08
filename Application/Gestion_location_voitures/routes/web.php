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
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * La route qui s'occupe du changement de langue
 */
Route::get('lang/', [LangController::class, 'change'])->name('changeLang');

/**
 * Route uniquement accessible en tant qu'invite
 */
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

/**
 * Routes uniquement accessible une fois la connexion reussis
 */
Route::middleware('auth')->group(function () {

    // Creation / Modification de comptes
    Route::get('/creation_modification_comptes', [CmcController::class, 'index'])
        ->name('CMC');

    Route::post('/creation_modification_comptes/update',[CmcController::class, 'update'])
        ->name('CMC.update');

    Route::post('/creation_modification_comptes',[CmcController::class, 'addUser'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.addUser');

    Route::get('/creation_modification_comptes/showUser/{id}', [CmcController::class, 'showUpdateUser'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.showUpdateUser');

    Route::post('/creation_modification_comptes/updateUser/{id}',[CmcController::class, 'updateUser'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.updateUser');

    Route::post('/creation_modification_comptes/{id}', [CmcController::class, 'delete'])
        ->middleware('categorie:Administrateur')
        ->name('CMC.delete');


    // Gestion de la flotte
    Route::get('/gestion_de_la_flotte', [GdfController::class, 'index'])
        ->middleware('categorie:Gestionnaire,Administrateur')
        ->name('GdF');

    Route::post('/gestion_de_la_flotte/addCar', [GdfController::class, 'addCar'])
        ->middleware('categorie:Gestionnaire')
        ->name('GdF.addCar');

    Route::post('/gestion_de_la_flotte/deleteCar/{id}', [GdfController::class, 'deleteCar'])
        ->middleware('categorie:Gestionnaire')
        ->name('GdF.deleteCar');

    Route::post('/gestion_de_la_flotte/updateStatut', [GdfController::class, 'updateStatut'])
        ->middleware('categorie:Gestionnaire')
        ->name('GdF.updateStatut');

    // Gestion des reservations
    Route::get('/gestion_des_reservation', [GdrController::class, 'index'])
        ->middleware('categorie:Client,Gestionnaire')
        ->name('GdR');

    Route::post('/gestion_des_reservation/bookCar', [GdrController::class, 'bookCar'])
        ->middleware('categorie:Client,Gestionnaire')
        ->name('GdR.bookCar');

    // Tableau de bord
    Route::get('/tableau_de_bord', [TdbController::class, 'index'])
        ->middleware('categorie:Gestionnaire,Administrateur')
        ->name('TdB');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
