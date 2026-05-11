<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'vente_id',
        'user_id',
        'montant',
        'mode_paiement',
        'date_paiement',
        'reference',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'montant'       => 'decimal:2',
            'date_paiement' => 'date',
        ];
    }

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
