<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {

        //On initialise un id en dur à 1 pour permettre que le profileSeeder re retrouve en base de donnée (admin_id : 1)
        User::factory()->create([
            'id' => 1,
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        //Appel du Profil Seeder dans DatabaseSeeder

        $this->call([
            ProfilSeeder::class,
        ]);
    }

}
