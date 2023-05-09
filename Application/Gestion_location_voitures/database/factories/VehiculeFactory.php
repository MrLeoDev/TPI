<?php

namespace Database\Factories;

use App\Enum\VehiculeTypeEnum;
use App\Enum\VehiculeStatutEnum;
use App\Enum\VehiculeTransmissionEnum;
use App\Models\Marque;
use App\Models\Modele;
use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicule>
 */
class VehiculeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generation d'image de voiture
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));

        return [
            'image' => 'img/vehicules/' . $faker->image(storage_path('app/public/img/vehicules'), 3000, 2000, ['car'], false),
            'id'=> $this->faker->vehicleRegistration,
            'tarif_journalier' => fake()->randomFloat(2,1,100),
            'marque_id' => Marque::inRandomOrder()->first(),
            'modele_id' => Modele::inRandomOrder()->first(),
            'type'=> VehiculeTypeEnum::cases()[rand(0,3)]->value,
            'statut' => VehiculeStatutEnum::cases()[rand(0,2)]->value,
            'transmission' => VehiculeTransmissionEnum::cases()[rand(0,1)]->value
        ];
    }
}
