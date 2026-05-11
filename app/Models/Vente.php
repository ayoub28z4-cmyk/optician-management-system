<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'ordonnance_id',
        'numero_facture',
        'date_vente',
        'remise',
        'total_ht',
        'total_ttc',
        'statut_paiement',
        'remarque',
    ];

    protected function casts(): array
    {
        return [
            'date_vente' => 'date',
            'remise'     => 'decimal:2',
            'total_ht'   => 'decimal:2',
            'total_ttc'  => 'decimal:2',
        ];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordonnance()
    {
        return $this->belongsTo(Ordonnance::class);
    }

    public function lignes()
    {
        return $this->hasMany(VenteLigne::class);
    }

    // Générer numéro facture unique
    public static function genererNumeroFacture(): string
    {
        $annee  = date('Y');
        $mois   = date('m');
        $dernier = static::whereYear('created_at', $annee)
                         ->whereMonth('created_at', $mois)
                         ->count();
        return 'FAC-' . $annee . $mois . '-' . str_pad($dernier + 1, 4, '0', STR_PAD_LEFT);
    }
    public function paiements()
    {
        return $this->hasMany(Paiement::class)->orderBy('date_paiement', 'desc');
    }

    public function getMontantPayeAttribute(): float
    {
        // Utilise la relation chargée en mémoire si dispo — évite le N+1
        if ($this->relationLoaded('paiements')) {
            return (float) $this->paiements->sum('montant');
        }
        return (float) $this->paiements()->sum('montant');
    }

    public function getResteAPayerAttribute(): float
    {
        return max(0.0, (float) $this->total_ttc - $this->montant_paye);
    }
}
