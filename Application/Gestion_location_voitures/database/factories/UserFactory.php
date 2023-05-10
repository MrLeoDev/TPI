<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Enum\UserCategorieEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Génération d'un utilisateur
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->lastName(),
            'prenom' => fake()->unique()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'categorie' => fake()->randomElement(UserCategorieEnum::cases()),
            'montant_des_locations' => fake()->randomDigit(),
            'remember_token' => Str::random(10),
        ];
    }
}
