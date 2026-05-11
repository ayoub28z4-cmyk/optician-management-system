<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteLigne extends Model
{
    protected $fillable = [
        'vente_id',
        'produit_id',
        'designation',
        'quantite',
        'prix_unitaire',
        'remise_ligne',
        'sous_total',
    ];

    protected function casts(): array
    {
        return [
            'prix_unitaire' => 'decimal:2',
            'remise_ligne'  => 'decimal:2',
            'sous_total'    => 'decimal:2',
        ];
    }

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
