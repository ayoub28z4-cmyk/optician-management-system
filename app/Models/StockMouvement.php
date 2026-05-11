<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMouvement extends Model
{
    protected $fillable = [
        'produit_id',
        'user_id',
        'type',
        'quantite',
        'stock_avant',
        'stock_apres',
        'motif',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
