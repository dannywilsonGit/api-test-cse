<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase; // Remet la DB à zéro pour chaque test
use Illuminate\Foundation\Testing\WithFaker; // Une bibliothèque qui génère de fausses données réalistes
use Tests\TestCase;
use App\Models\User;
use App\Models\Profil;
use Laravel\Sanctum\Sanctum; // Je rappelle explicitement Sanctum pour authentifier l'utilisateur dans les tests
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfilControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Je crée un utilisateur (ici administrateur) et on l'authentifie pour les tests qui le nécessitent
        $this->admin = User::factory()->create();
    }

    public function test_public_can_get_active_profils_without_status(): void
    {
        Profil::factory()->count(2)->create(['statut' => 'actif']);
        Profil::factory()->create(['statut' => 'inactif']);

        $response = $this->getJson('/api/profils/public');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data') // Je vérifie ici que seuls les profils actifs sont retournés
            ->assertJsonPath('data.0.nom', fn ($nom) => !empty($nom)) // Ensuite qu'un nom est présent
            ->assertJsonMissingPath('data.0.statut'); // et finalement que le statut n'est PAS retourné
    }

    public function test_admin_can_create_profil_with_image(): void
    {
        Sanctum::actingAs($this->admin);
        Storage::fake('public'); // je simule le stockage

        $file = UploadedFile::fake()->image('avatar.jpg');

        $profilData = [
            'nom' => 'Alex',
            'prenom' => 'John',
            'statut' => 'actif',
            'image' => $file,
        ];

        $response = $this->postJson('/api/profils', $profilData);

        $response->assertStatus(201) // HTTP 201 Created
        ->assertJsonPath('data.nom', 'Alex')
            ->assertJsonPath('data.statut', 'actif');

        $this->assertDatabaseHas('profils', ['nom' => 'Alex', 'admin_id' => $this->admin->id]); //je teste qu'il existe bien en base de donnée
        $profil = Profil::first();
        Storage::disk('public')->assertExists($profil->image); // Je verifie que l'image est stockée

    }

    public function test_admin_cannot_create_profil_with_invalid_data(): void
    {
        Sanctum::actingAs($this->admin);
        $response = $this->postJson('/api/profils', ['nom' => '']); // J'essaye d'envoyer des données invalides , nom vide

        $response->assertStatus(422) // HTTP 422 (Erreur de validation )
        ->assertJsonValidationErrors(['nom']);
    }

    public function test_admin_can_update_profil(): void
    {
        Sanctum::actingAs($this->admin);
        $profil = Profil::factory()->create(['admin_id' => $this->admin->id]);

        $updatedData = ['nom' => 'Danny', 'statut' => 'inactif']; //On essaye une petite modif
        $response = $this->putJson("/api/profils/{$profil->id}", $updatedData);

        $response->assertStatus(200) //et on verifie si la requete de modification put a marché
            ->assertJsonPath('data.nom', 'Danny')
            ->assertJsonPath('data.statut', 'inactif');
        $this->assertDatabaseHas('profils', ['id' => $profil->id, 'nom' => 'Danny']);
    }

    public function test_admin_can_delete_profil(): void
    {
        Sanctum::actingAs($this->admin);
        Storage::fake('public');
        $file = UploadedFile::fake()->image('image.jpg');
        $path = $file->store('profils_images', 'public');
        $profil = Profil::factory()->create(['admin_id' => $this->admin->id, 'image' => $path]);

        $response = $this->deleteJson("/api/profils/{$profil->id}");

        $response->assertStatus(204); // Le profil bel et bien supprimé
        $this->assertDatabaseMissing('profils', ['id' => $profil->id]);//On vérifie finalement qu'il n'existe plus dans la table profils en base On est content
        Storage::disk('public')->assertMissing($path);
    }

}
