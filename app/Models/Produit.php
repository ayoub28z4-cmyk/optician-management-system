<?php

namespace App\Models;

use App\Models\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'societe_id',
        'type_article_id',
        'designation_id',
        'quantite_stock',
        'seuil_alerte',
        'prix_achat_actuel',
    ];

    protected function casts(): array
    {
        return [
            'prix_achat_actuel' => 'decimal:2',
            'quantite_stock'    => 'integer',
            'seuil_alerte'      => 'integer',
        ];
    }

    public function societe(): BelongsTo
    {
        return $this->belongsTo(Societe::class);
    }

    public function typeArticle(): BelongsTo
    {
        return $this->belongsTo(TypeArticle::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(MouvementStock::class);
    }

    /** Garde la compatibilité avec VenteService / VenteLigne */
    public function stockMouvements(): HasMany
    {
        return $this->hasMany(StockMouvement::class)->orderBy('created_at', 'desc');
    }

    public function getLabelAttribute(): string
    {
        return "{$this->societe->nom} — {$this->typeArticle->nom} — {$this->designation->nom}";
    }
}
