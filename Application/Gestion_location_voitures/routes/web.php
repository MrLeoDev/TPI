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
    Route::get('/creation_modification_comptes', [CmcController::class, 'index'])->name('CMC');

    // Gestion de la flotte
    Route::middleware('categorie:Gestionnaire,Administrateur')->group(function () {
        Route::get('/gestion_de_la_flotte', [GdfController::class, 'index'])->name('GdF');
    });

    // Gestion des reservations
    Route::middleware('categorie:Client,Gestionnaire')->group(function () {
        Route::get('/gestion_des_reservation', [GdrController::class, 'index'])->name('GdR');
    });

    // Tableau de bord
    Route::middleware('categorie:Gestionnaire,Administrateur')->group(function () {
        Route::get('/tableau_de_bord', [TdbController::class, 'index'])->name('TdB');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
