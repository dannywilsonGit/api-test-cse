<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Profil;
use Illuminate\Http\Request;
use App\Http\Resources\CommentaireResource;
use App\Services\CommentaireService;
use App\Http\Requests\StoreCommentaireRequest;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    protected CommentaireService $commentaireService;

    public function __construct(CommentaireService $commentaireService)
    {
        $this->commentaireService = $commentaireService;
    }

    // Endpoint protégé (POST /profils/{profil}/commentaires)
    public function store(StoreCommentaireRequest $request, Profil $profil)
    {
        // La contrainte "Un administrateur ne peut poster qu'un commentaire sur un profil"
        // est gérée par la clé unique en DB.
        // je fais en sorte que la  FormRequest valide aussi que le profil existe.

        $commentaire = $this->commentaireService->createCommentaire(
            $request->validated(),
            $profil,
            Auth::user()
        );
        return new CommentaireResource($commentaire);
    }
}
