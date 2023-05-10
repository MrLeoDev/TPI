<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Générer et intégrer les données dans la base de donnée
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Modele::factory(10)->create();
        \App\Models\Marque::factory(10)->create();
        \App\Models\Vehicule::factory(10)->create();
    }
}
