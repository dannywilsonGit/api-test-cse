<?php

// tests/Feature/CommentaireControllerTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profil;
use App\Models\Commentaire;
use Laravel\Sanctum\Sanctum;

class CommentaireControllerTest extends TestCase
{
    use RefreshDatabase;//Pareil comme le test de Profil , je remet la base de donnée a Zero pour chaqu test

    protected User $admin;
    protected Profil $profil;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        $this->profil = Profil::factory()->create(['admin_id' => User::factory()->create()->id]); // Créé par un autre admin pour éviter toute confusion
        Sanctum::actingAs($this->admin);
    }

    public function test_admin_can_add_comment_to_profil(): void
    {
        $commentaireData = ['contenu' => 'Super profil !'];

        $response = $this->postJson("/api/profils/{$this->profil->id}/commentaires", $commentaireData);

        $response->assertStatus(201)//Commentaire crée avec succès
            ->assertJsonPath('data.contenu', 'Super profil !'); //Je verifie ici que le contenu est bon

        $this->assertDatabaseHas('commentaires', [//Et apres comme d'habitude je verifie que le commentaire existe en base de donnée
            'profil_id' => $this->profil->id,
            'admin_id' => $this->admin->id,
            'contenu' => 'Super profil !'
        ]);
    }

    public function test_admin_cannot_add_more_than_one_comment_to_same_profil(): void
    {
        //On rajoute dans un premier tempps le premier commentaire
        Commentaire::factory()->create([
            'profil_id' => $this->profil->id,
            'admin_id' => $this->admin->id,
            'contenu' => 'Premier commentaire.'
        ]);

        // Tentative d'ajout d'un second commentaire
        $commentaireData = ['contenu' => 'Second commentaire inutile.']; //J'initialise un second commentaire
        $response = $this->postJson("/api/profils/{$this->profil->id}/commentaires", $commentaireData);//Et je tente de le post sur le meme profil que tout à l'heure

        // Le test nous renverra soit une validation Laravel (422), soit une erreur 500 SQL comme violation de contrainte BDD come défini dans mon fichier de migration
        $response->assertStatus(422); // validation dans le contrôleur

        // On s'assure qu'il n’y a pas de deuxième commentaire et que le nombre de commentaires reste égal à 1
        $this->assertDatabaseCount('commentaires', 1);
    }


    public function test_unauthenticated_user_cannot_add_comment(): void
    {
        // Je force ou disons plutot que j'efface tout utilisateur connecté
        $this->app['auth']->forgetGuards();

        $commentaireData = ['contenu' => 'Je suis un fantôme.'];
        $response = $this->postJson("/api/profils/{$this->profil->id}/commentaires", $commentaireData);

        $response->assertStatus(401); // Bon resultat ,l'utilisateur non connecté n'a pas le droit de rajouter un commentaire , ON est content tout marche
    }
}
