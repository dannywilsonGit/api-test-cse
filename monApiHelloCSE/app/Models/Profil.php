<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;




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


    /**
     * @return BelongsTo<User, Profil>
     */
    public function administrateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * @return HasMany<Commentaire, Profil>
     */

    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class);
    }
}
