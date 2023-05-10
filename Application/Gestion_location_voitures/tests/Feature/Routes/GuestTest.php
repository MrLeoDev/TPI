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
 * Route pour le changement de langue du site
 */
test('[CHANGEMENT DE LANGUE] : Accès possible.', function () {
    $response = $this->get('/lang/?lang=');
    $response->assertStatus(302);
});
