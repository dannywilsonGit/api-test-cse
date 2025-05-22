<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    /** @use HasFactory<\Database\Factories\CommentaireFactory> */
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'profil_id',
        'contenu',
    ];

    public function administrateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function profil(): BelongsTo
    {
        return $this->belongsTo(Profil::class);
    }
}
