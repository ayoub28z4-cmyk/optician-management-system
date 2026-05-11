<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MouvementStock extends Model
{
    use HasFactory;

    protected $table = 'mouvements_stock';

    protected $fillable = [
        'produit_id',
        'type_mouvement',
        'quantite',
        'prix_unitaire',
        'date_mouvement',
    ];

    protected function casts(): array
    {
        return [
            'date_mouvement' => 'date',
            'quantite'       => 'integer',
            'prix_unitaire'  => 'decimal:2',
        ];
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
