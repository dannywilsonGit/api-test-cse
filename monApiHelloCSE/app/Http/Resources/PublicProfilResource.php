<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicProfilResource extends JsonResource
{
    public static $wrap = 'profil';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'admin_id_createur' => $this->admin_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            // Je n'inclus pas le statut ici
            'commentaires' => CommentaireResource::collection($this->whenLoaded('commentaires')),
        ];
    }
}
