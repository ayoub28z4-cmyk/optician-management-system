<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'date_ordonnance',
        'medecin',
        'od_sphere',
        'od_cylindre',
        'od_axe',
        'og_sphere',
        'og_cylindre',
        'og_axe',
        'addition',
        'ecart_pupillaire',
        'remarques',
    ];

    protected function casts(): array
    {
        return [
            'date_ordonnance' => 'date',
            'od_sphere'       => 'decimal:2',
            'od_cylindre'     => 'decimal:2',
            'od_axe'          => 'decimal:2',
            'og_sphere'       => 'decimal:2',
            'og_cylindre'     => 'decimal:2',
            'og_axe'          => 'decimal:2',
            'addition'        => 'decimal:2',
            'ecart_pupillaire'=> 'decimal:2',
        ];
    }

    // Relations
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Date d'éligibilité mutuelle — 2 ans après l'ordonnance
    public function getDateEligibiliteAttribute()
    {
        return $this->date_ordonnance->addYears(2);
    }

    // Jours restants avant éligibilité
    public function getJoursRestantsAttribute(): int
    {
        return now()->diffInDays($this->date_eligibilite, false);
    }
    public function rappel()
    {
        return $this->hasOne(Rappel::class);
    }
}
