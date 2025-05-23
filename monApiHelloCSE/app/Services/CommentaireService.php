<?php


namespace App\Services;

use App\Models\Commentaire;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Support\Facades\DB; // Pour la gestion d'erreur de la contrainte unique
use Illuminate\Validation\ValidationException;



class CommentaireService
{

    /**
     * @param array{contenu: string} $data
     */
    public function createCommentaire(array $data, Profil $profil, User $admin): Commentaire
    {
        $data['admin_id'] = $admin->id;
        $data['profil_id'] = $profil->id;

        try {
            return Commentaire::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            // Vérifie si l'erreur est due à la violation de la contrainte unique
            $sqlErrorCode = $e->errorInfo[1];
            if ($sqlErrorCode == 1062) { // Code d'erreur MySQL pour entrée dupliquée
                throw ValidationException::withMessages([
                    'profil_id' => ['Cet administrateur a déjà posté un commentaire sur ce profil.'],
                ]);
            }

            throw $e;
        }
    }
}
