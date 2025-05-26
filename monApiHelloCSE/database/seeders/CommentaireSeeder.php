<?php

namespace Database\Seeders;

use App\Models\Commentaire;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Je verifie s'il y'a des profiles et des admins
        if (Profil::count() === 0 || User::count() === 0) {
            $this->call([ProfilSeeder::class]);
        }

        // 1 commentaire par profil
        Profil::each(function ($profil) {
            Commentaire::factory()->create([
                'admin_id' => User::inRandomOrder()->first()->id,
                'profil_id' => $profil->id,
                'contenu' => fake()->paragraph(2)
            ]);
        });


    }
}
