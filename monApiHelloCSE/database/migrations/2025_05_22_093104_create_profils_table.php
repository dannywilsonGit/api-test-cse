<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'admin_id')->constrained('users')->cascadeOnDelete(); // Clé étrangère vers la table admin (J'utilise users dans mon cas)
            $table->string('nom');
            $table->string('prenom');
            $table->string('image')->nullable(); // Chemin vers l'image
            $table->enum('statut', ['inactif', 'en attente', 'actif'])->default('en attente'); //champs statut (une énumeration) par défaut "en attente"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
