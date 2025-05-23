<?php

namespace App\Http\Resources;

use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Profil
 */

class PublicProfilResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @phpstan-return array{
     *     id: int,
     *     nom: string,
     *     prenom: string,
     *     image_url: string|null,
     *     admin_id_createur: int,
     *     created_at: string,
     *     updated_at: string,
     *     commentaires: \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * }
     */
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
