<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'client_id',
        'user_id',
        'date_heure',
        'motif',
        'commentaire',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_heure' => 'datetime',
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

    // Accesseur — heure formatée
    public function getHeureAttribute(): string
    {
        return $this->date_heure->format('H:i');
    }

    // Accesseur — date formatée
    public function getDateAttribute(): string
    {
        return $this->date_heure->format('d/m/Y');
    }
}
