<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rappel extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'ordonnance_id',
        'user_id',
        'date_reference',
        'date_eligibilite',
        'date_rappel_prevu',
        'statut',
        'note_contact',
        'traite_par',
        'traite_at',
    ];

    protected function casts(): array
    {
        return [
            'date_reference'    => 'date',
            'date_eligibilite'  => 'date',
            'date_rappel_prevu' => 'date',
            'traite_at'         => 'datetime',
        ];
    }

    // Relations
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function ordonnance()
    {
        return $this->belongsTo(Ordonnance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    // Jours restants avant date de rappel
    public function getJoursAvantRappelAttribute(): int
    {
        return now()->diffInDays($this->date_rappel_prevu, false);
    }

    // Urgence du rappel
    public function getUrgenceAttribute(): string
    {
        $jours = $this->jours_avant_rappel;
        if ($jours <= 0)  return 'urgent';
        if ($jours <= 30) return 'proche';
        if ($jours <= 90) return 'normal';
        return 'lointain';
    }
}
