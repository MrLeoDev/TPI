<?php

use App\Enum\UserCategorieEnum;
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

test('[GESTION - RESERVATION] : Accès possible.', function () {
    // Categorie d'utilisateur
    $client = User::factory()->state(['categorie' => UserCategorieEnum::CLIENT])->create();
    $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
    $admin = User::factory()->state(['categorie' => UserCategorieEnum::ADMIN])->create();

    /**
     * Resultat attendu
     */

    //Client
    $response = $this->actingAs($client)->get(route('GdR'));
    $response->assertStatus(200);

    // Gestionnaire
    $response = $this->actingAs($gestionnaire)->get(route('GdR'));
    $response->assertStatus(200);

    // Administrateur
    $response = $this->actingAs($admin)->get(route('GdR'));
    $response->assertStatus(302);
});

test('[GESTION - FLOTTE] : Accès possible.', function () {
   // Categorie d'utilisateur
   $client = User::factory()->state(['categorie' => UserCategorieEnum::CLIENT])->create();
   $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
   $admin = User::factory()->state(['categorie' => UserCategorieEnum::ADMIN])->create();

   /**
    * Resultat attendu
    */

   //Client
   $response = $this->actingAs($client)->get(route('GdF'));
   $response->assertStatus(302);

   // Gestionnaire
   $response = $this->actingAs($gestionnaire)->get(route('GdF'));
   $response->assertStatus(200);

   // Administrateur
   $response = $this->actingAs($admin)->get(route('GdF'));
   $response->assertStatus(200);
});

test('[TABLEAU DE BORD] : Accès possible.', function () {
    // Categorie d'utilisateur
   $client = User::factory()->state(['categorie' => UserCategorieEnum::CLIENT])->create();
   $gestionnaire = User::factory()->state(['categorie' => UserCategorieEnum::GESTION])->create();
   $admin = User::factory()->state(['categorie' => UserCategorieEnum::ADMIN])->create();

   /**
    * Resultat attendu
    */

   //Client
   $response = $this->actingAs($client)->get(route('TdB'));
   $response->assertStatus(302);

   // Gestionnaire
   $response = $this->actingAs($gestionnaire)->get(route('TdB'));
   $response->assertStatus(200);

   // Administrateur
   $response = $this->actingAs($admin)->get(route('TdB'));
   $response->assertStatus(200);
});

