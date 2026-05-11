<?php

namespace App\Services;

use App\Models\Rappel;
use App\Models\Ordonnance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class RappelService
{
    // Générer automatiquement un rappel quand une ordonnance est créée
    public function genererDepuisOrdonnance(Ordonnance $ordonnance): ?Rappel
    {
        // Ne pas créer si un rappel existe déjà
        if ($ordonnance->rappel) {
            return null;
        }

        $delai = (int) config('optigest.delai_rappel_jours', 60);

        $dateEligibilite = $ordonnance->date_ordonnance->copy()->addYears(2);
        $dateRappel      = $dateEligibilite->copy()->subDays($delai);

        return Rappel::create([
            'client_id'         => $ordonnance->client_id,
            'ordonnance_id'     => $ordonnance->id,
            'user_id'           => Auth::id(),
            'date_reference'    => $ordonnance->date_ordonnance,
            'date_eligibilite'  => $dateEligibilite,
            'date_rappel_prevu' => $dateRappel,
            'statut'            => 'a_contacter',
        ]);
    }

    // Liste des rappels avec filtres
    public function liste(array $filtres): LengthAwarePaginator
    {
        $query = Rappel::with(['client', 'ordonnance'])
                       ->orderBy('date_rappel_prevu', 'asc');

        if (!empty($filtres['statut'])) {
            $query->where('statut', $filtres['statut']);
        }

        if (!empty($filtres['urgence'])) {
            match($filtres['urgence']) {
                'urgent' => $query->where('date_rappel_prevu', '<=', now()),
                'proche' => $query->whereBetween('date_rappel_prevu', [now(), now()->addDays(30)]),
                'normal' => $query->whereBetween('date_rappel_prevu', [now()->addDays(30), now()->addDays(90)]),
                default  => null,
            };
        }

        return $query->paginate(10);
    }

    // Rappels urgents pour le dashboard
    public function urgents(): \Illuminate\Database\Eloquent\Collection
    {
        return Rappel::with('client')
                     ->whereIn('statut', ['a_contacter', 'contacte', 'relance'])
                     ->where('date_rappel_prevu', '<=', now()->addDays(60))
                     ->orderBy('date_rappel_prevu', 'asc')
                     ->limit(10)
                     ->get();
    }

    // Mettre à jour le statut + note
    public function mettreAJourStatut(Rappel $rappel, string $statut, ?string $note = null): Rappel
    {
        $data = ['statut' => $statut];

        if ($note) {
            $data['note_contact'] = $note;
        }

        if ($statut === 'traite') {
            $data['traite_par'] = Auth::id();
            $data['traite_at']  = now();
        }

        $rappel->update($data);
        return $rappel;
    }
}
