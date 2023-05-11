<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;

/**
 * Test sur les connexions dans la page "LOGIN"
 */

test('[LOGIN] : Les utilisateurs peuvent se connecter à l\'application', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('[LOGIN] : Les utilisateurs ne peuvent pas se connecter avec un mauvais mot de passe', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
