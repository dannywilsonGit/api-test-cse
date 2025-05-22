<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

enum StatutProfil: string {
     case INACTIF = 'inactif';
     case EN_ATTENTE = 'en attente';
     case ACTIF = 'actif';
 }
class Profil extends Model
{
    /** @use HasFactory<\Database\Factories\ProfilFactory> */
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'nom',
        'prenom',
        'image',
        'statut',
    ];


     protected $casts = [
         'statut' => StatutProfil::class,
     ];

    public function administrateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class);
    }
}
