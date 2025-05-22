<?php

namespace Database\Factories;

use App\Models\Profil;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commentaire>
 */
class CommentaireFactory extends Factory
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
            'admin_id' => User::factory(),
            'profil_id' => Profil::factory(),
            'contenu' => fake()->paragraph(),
        ];
    }
}
