<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/**
 * Route pour les invités
 */
Route::middleware('guest')->group(function () {

    /**
     * Login
     */
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

/**
 * Route pour les utilisateurs
 */
Route::middleware('auth')->group(function () {
    /**
     * Pour s'assurer de la déconnexion de l'utilisateur
     */
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
