<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProfilResource;
use App\Http\Resources\PublicProfilResource;
use App\Services\ProfilService;
use App\Http\Requests\StoreProfilRequest;
use App\Http\Requests\UpdateProfilRequest;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    protected ProfilService $profilService;

    public function __construct(ProfilService $profilService)
    {
        $this->profilService = $profilService;
    }

    // Endpoint public (GET /profils/public)
    public function indexPublic(): JsonResource
    {
        $profils = $this->profilService->getActivePublicProfils();
        return PublicProfilResource::collection($profils);
    }

    // Endpoint protégé (POST /profils)
    public function store(StoreProfilRequest $request):JsonResponse // Utilise la FormRequest
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $profil = $this->profilService->createProfil($request->validated(),$user);
        return response()->json([
            'data' => new ProfilResource($profil),
        ], 201);
    }

    // Endpoint protégé (GET /profils/{profil}). Pour voir un profil avec son statut
    public function show(Profil $profil):JsonResponse
    {
        return response()->json([
            'data' => new ProfilResource($profil->load('commentaires')),
        ]);
    }

    // Endpoint protégé (PUT /profils/{profil})
    public function update(UpdateProfilRequest $request, Profil $profil):JsonResponse
    {
        $updatedProfil = $this->profilService->updateProfil($profil, $request->validated());
        return response()->json([
            'data' => new ProfilResource($updatedProfil),
        ]);
    }

    // Endpoint protégé (DELETE /profils/{profil})
    public function destroy(Profil $profil):JsonResponse
    {

        $this->profilService->deleteProfil($profil);
        return response()->json(null, 204); //Aucun contenu
    }
}
