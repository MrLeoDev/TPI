<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

/**
 * Il s'agit des tests sur l'acces des pages (Url) uniquement si nous sommes connecter
 */

test('[CONFIRMATION MDP] : Accès possible.', function () {
    $user = User::factory()->create();

    // $response = $this->actingAs($user)->get('/confirm-password');
    $response = $this->actingAs($user)->get(route('password.confirm'));
    $response->assertStatus(200);
});

test('[RÉINITIALISATION MDP] : Accès possible.', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get('/reset-password/'.$notification->token);

        $response->assertStatus(200);

        return true;
    });
});

test('[CREATION/MODIFICATION - COMPTES] : Accès possible.', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('CMC'));

    $response->assertStatus(200);
});

