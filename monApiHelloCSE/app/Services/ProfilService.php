<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Profil;

class ProfilService
{
    /**
     * @return Collection<int, Profil>
     */
    public function getActivePublicProfils(): Collection
    {
        return Profil::where('statut', 'actif')->with('commentaires')->get();
    }


    /**
     * @param array{nom: string, prenom: string, image?: \Illuminate\Http\UploadedFile|null, statut: string} $data
     */
    public function createProfil(array $data, User $admin): Profil
    {
        $data['admin_id'] = $admin->id;

        if (isset($data['image'])) {
            $path = $data['image']->store('profils_images', 'public');
            $data['image'] = $path;
        }

        return Profil::create($data);
    }

    /**
     * @param array{nom?: string, prenom?: string, image?: \Illuminate\Http\UploadedFile|null, statut?: string} $data
     */
    public function updateProfil(Profil $profil, array $data): Profil
    {
        if (isset($data['image'])) {
// Supprimer l'ancienne image si elle existe
            if ($profil->image) {
                Storage::disk('public')->delete($profil->image);
            }
            $path = $data['image']->store('profils_images', 'public');
            $data['image'] = $path;
        } elseif (array_key_exists('image', $data) && $data['image'] === null) {
// Si 'image' est explicitement mis à null (pour supprimer l'image)
            if ($profil->image) {
                Storage::disk('public')->delete($profil->image);
            }
            $data['image'] = null;
        }


        $profil->update($data);
        return $profil->fresh(); // Récupère le modèle frais avec les relations
    }

    public function deleteProfil(Profil $profil): void
    {
        if ($profil->image) {
            Storage::disk('public')->delete($profil->image);
        }
// Les commentaires associés seront supprimés en cascade grâce à la contrainte FK (si configuré)
// Sinon, il faudrait les supprimer manuellement : $profil->commentaires()->delete();
        $profil->delete();
    }
}
