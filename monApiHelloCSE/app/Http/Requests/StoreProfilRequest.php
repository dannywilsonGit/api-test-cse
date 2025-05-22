<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // L'authentification est gérée par le middleware auth:sanctum
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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 'sometimes' car peut être null
            'statut' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, ['inactif', 'en attente', 'actif'])) {
                        $fail("Le statut '{$value}' n'est pas valide.");
                    }
                },
            ],
            // admin_id sera ajouté à partir de l'utilisateur authentifié dans le service/controller
        ];
    }
}
