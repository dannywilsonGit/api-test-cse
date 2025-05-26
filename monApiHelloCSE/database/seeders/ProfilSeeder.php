<?php

namespace Database\Seeders;

use App\Models\Profil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Création d'un dossier temporaire pour les images
        if (!Storage::exists('public/profils')) {
            Storage::makeDirectory('public/profils');
        }

        //On va créer au moins un seeder de profil actif
        Profil::factory()->create([
            'admin_id' => 1,
            'nom' => 'Profil Test',
            'prenom' => 'Test',
            'image' => $this->generateFakeImage(),
            'statut'=>'actif'
        ]);

    }

    private function generateFakeImage(): string
    {
        return 'profils/default.jpg';
    }
}
