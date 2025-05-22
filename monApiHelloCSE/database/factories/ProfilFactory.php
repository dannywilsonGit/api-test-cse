<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profil>
 */
class ProfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'admin_id' => User::factory(), // On va créer un administrateur si non fourni
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'image' => null,
            'statut' => fake()->randomElement(['inactif', 'en attente', 'actif']),
        ];
    }
}
