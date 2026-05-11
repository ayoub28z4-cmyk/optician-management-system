<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

   protected $fillable = [
    'prenom',
    'nom',
    'cin',
    'genre',
    'date_naissance',
    'telephone',
    'email',
    'adresse',
    'observations',
    'classement_registre',
    'type',
    'mutuelle_type',
    'mutuelle_autre',
    'is_active',
    'user_id',
];

    protected function casts(): array
    {
        return [
            'date_naissance' => 'date',
            'is_active'      => 'boolean',
        ];
    }

    // Accesseur — nom complet
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // Accesseur — initiales pour l'avatar
    public function getInitialesAttribute(): string
    {
        return strtoupper(substr($this->prenom, 0, 1) . substr($this->nom, 0, 1));
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class)->orderBy('date_ordonnance', 'desc');
    }

    public function derniereOrdonnance()
    {
        return $this->hasOne(Ordonnance::class)->latestOfMany('date_ordonnance');
    }
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class)->orderBy('date_heure', 'desc');
    }
    public function rappels()
    {
        return $this->hasMany(Rappel::class)->orderBy('date_rappel_prevu', 'asc');
    }
    public function getMutuelleLabelAttribute(): string
    {
        return match($this->mutuelle_type) {
            'cnops'  => 'CNOPS',
            'cnss'   => 'CNSS',
            'autre'  => $this->mutuelle_autre ?? 'Autre',
            'aucune' => 'Aucune',
            default  => '—',
        };
    }

    public function getMutuelleColorAttribute(): array
    {
        return match($this->mutuelle_type) {
            'cnops'  => ['bg' => '#dbeafe', 'color' => '#1d4ed8'],
            'cnss'   => ['bg' => '#dcfce7', 'color' => '#16a34a'],
            'autre'  => ['bg' => '#fef9c3', 'color' => '#ca8a04'],
            'aucune' => ['bg' => '#f1f5f9', 'color' => '#64748b'],
            default  => ['bg' => '#f1f5f9', 'color' => '#64748b'],
        };
    }
    
}
