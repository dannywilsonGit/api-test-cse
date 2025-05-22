<?php

namespace Database\Seeders;

use App\Models\Profil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //On va créer au moins un seeder de profil
        Profil::factory()->create([
            'admin_id' => 1,
            'nom' => 'Profil Test',
            'prenom' => 'Test',
            'image' => null,
            'statut'=>'actif'
        ]);

    }
}
