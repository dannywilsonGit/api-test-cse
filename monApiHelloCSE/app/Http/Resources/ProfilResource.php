<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfilResource extends JsonResource
{
    public static $wrap = 'profil';// enveloppe la ressource

    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            // 'statut' => $this->statut, // Sera inclus par défaut
            'admin_id_createur' => $this->admin_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'commentaires' => CommentaireResource::collection($this->whenLoaded('commentaires')),
        ];

        // Masquer le statut si l'utilisateur n'est pas authentifié (pour l'endpoint public)

        if (auth()->check()) {
            $data['statut'] = $this->statut;
        }

        return $data;
    }
}
