<?php

/**
 * Test sur la page Création / Modification de comptes
 */

use App\Enum\UserCategorieEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Tout les utilisateurs
 */
test('[UPDATE MDP] : Les utilisateurs peuvent mettre à jour le mdp', function () {
    $user = User::factory()->create();

    $mdpUpdate = array (
        'password' => 'newPassword' ,
        'password_confirmation'=> 'newPassword',
    );

    $response = $this
         ->actingAs($user)
         ->post(route('CMC.update'), $mdpUpdate);

    $this->assertTrue(Hash::check('newPassword', $user->password));
    $this->assertFalse(Hash::check('oldpassword', $user->password));

    $response->assertStatus(302);
});

/**
 * Administrateur
 */
test('[AJOUTER COMPTE] : Les administrateurs peuvent ajouter un compte', function () {
    $categorie = UserCategorieEnum::cases()[rand(0,2)]->value;
    $admin = User::factory()->state(['categorie' => UserCategorieEnum::ADMIN])->create();

    $compteAdd = array (
        'prenom' => 'Test' ,
        'nom'=> 'Modifier',
        'email' => 'FakeEmailUpdate@test.com',
        'categorie' => $categorie,
        'password' => 'newPassword' ,
        'password_confirmation'=> 'newPassword',
    );

    $response = $this
         ->actingAs($admin)
         ->post(route('CMC.addUser'), $compteAdd);

    // Résultat
    $compte = User::where('prenom', $compteAdd['prenom'])->first();
    $this->assertEquals('Test', $compte->prenom);
    $this->assertEquals('Modifier', $compte->nom);
    $this->assertEquals('FakeEmailUpdate@test.com', $compte->email);
    $this->assertEquals($categorie, $compte->categorie->value);
    $this->assertTrue(Hash::check('newPassword', $compte->password));
    $this->assertFalse(Hash::check('oldpassword', $compte->password));

    $response->assertStatus(302);
});

test('[MODIFIER COMPTE] : Les administrateurs peuvent modifier un compte', function () {
    $categorie = UserCategorieEnum::cases()[rand(0,2)]->value;
    $admin = User::factory()->state(['categorie' => UserCategorieEnum::ADMIN])->create();
    $compte = User::factory()->state(['categorie' => $categorie])->create();

    $compteUpdate = array (
        'prenom' => 'Test' ,
        'nom'=> 'Modifier',
        'email' => 'FakeEmailUpdate@test.com',
        'categorie' => $categorie,
        'password' => 'newPassword' ,
        'password_confirmation'=> 'newPassword',
    );

    $response = $this
         ->actingAs($admin)
         ->post(route('CMC.updateUser', $compte->id), $compteUpdate);

    // Résultat
    $compte = User::find($compte->id);
    $this->assertEquals('Test', $compte->prenom);
    $this->assertEquals('Modifier', $compte->nom);
    $this->assertEquals('FakeEmailUpdate@test.com', $compte->email);
    $this->assertEquals($categorie, $compte->categorie->value);
    $this->assertTrue(Hash::check('newPassword', $compte->password));
    $this->assertFalse(Hash::check('oldpassword', $compte->password));

    $response->assertStatus(302);
});

test('[SUPPRIMER COMPTE] : Les administrateurs peuvent supprimer un compte', function () {
    $categorie = UserCategorieEnum::cases()[rand(0,2)]->value;
    $admin = User::factory()->state(['categorie' => UserCategorieEnum::ADMIN])->create();
    $compte = User::factory()->state(['categorie' => $categorie])->create();

    $response = $this
         ->actingAs($admin)
         ->post(route('CMC.delete', $compte->id));

    // Résultat
    $this->assertDatabaseMissing('users', ['id' => $compte->id]);
    $response->assertStatus(302);
});
