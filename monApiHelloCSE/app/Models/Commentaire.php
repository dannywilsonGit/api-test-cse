<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property int $admin_id
 * @property int $profil_id
 * @property string $contenu
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read \App\Models\User $administrateur
 * @property-read \App\Models\Profil $profil
 */
class Commentaire extends Model
{
    /** @use HasFactory<\Database\Factories\CommentaireFactory> */
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'profil_id',
        'contenu',
    ];

    /**
     * @return BelongsTo<User, Commentaire>
     */
    public function administrateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * @return BelongsTo<Profil, Commentaire>
     */
    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }
}
