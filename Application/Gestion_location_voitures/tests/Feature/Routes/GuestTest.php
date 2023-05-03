<?php
/**
 * Il s'agit des tests sur l'acces des pages (URL) si nous ne sommes pas connecter
 */

 /**
 * Route pour la page de connexion
 */
test('[CONNEXION] : Accès possible.', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

/**
 * Route pour la page de réinitialisation du mot de passe
 */
test('[MOT DE PASSE OUBLIÉ]  : Accès possible.', function () {
    $response = $this->get('/forgot-password');
    $response->assertStatus(200);
});

/**
 * Route pour le changement de langue du site
 */
// test('[<fg=#1BFF00>CHANGEMENT DE LANGUE</>] : <options=bold>Accès possible.</>', function () {
//     $response = $this->get('/lang/?lang=');
//     $response->assertStatus(302);
// });
