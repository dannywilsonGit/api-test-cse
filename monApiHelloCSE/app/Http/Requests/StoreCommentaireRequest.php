<?php

namespace App\Http\Requests;

use App\Models\Commentaire;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StoreCommentaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'contenu' => 'required|string',
            // profil_id sera pris de la route
            // admin_id sera pris de l'utilisateur authentifié

        ];
    }

    protected function passedValidation()
    {
        // on vérifie la contrainte "un admin par commentaire sur un profil" explicitement en plus de cette de la migration
        //En test on aura ainsi la possibilité de renvoyer soit une erreur de validation 422 soit une erreur SQL 500 DE VIOLATION DE CONTRAINTE
         $profilId = $this->route('profil')->id; // Accède à l'objet Profil injecté
         $adminId = Auth::id();

         $existingComment = Commentaire::where('profil_id', $profilId)
                                         ->where('admin_id', $adminId)
                                         ->exists();

         if ($existingComment) {
             throw ValidationException::withMessages([
                 'profil_id' => ['Cet administrateur a déjà commenté ce profil.'],
             ]);
         }
    }


}
