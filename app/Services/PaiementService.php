<?php

namespace App\Services;

use App\Models\Vente;
use App\Models\Paiement;
use App\Http\Requests\StorePaiementRequest;
use Illuminate\Support\Facades\Auth;

class PaiementService
{
    public function enregistrer(StorePaiementRequest $request, Vente $vente): Paiement
    {
        $montantDemande = (float) $request->montant;

        // Garde-fou contre les valeurs négatives ou nulles
        if ($montantDemande <= 0) {
            throw new \InvalidArgumentException('Le montant du paiement doit être positif.');
        }

        // Charge les paiements en mémoire pour éviter le N+1 sur reste_a_payer
        $vente->loadMissing('paiements');
        $resteAPayer = $vente->reste_a_payer;

        // Plafonne au reste à payer réel
        $montant = min($montantDemande, $resteAPayer);

        $paiement = Paiement::create([
            'vente_id'      => $vente->id,
            'user_id'       => Auth::id(),
            'montant'       => $montant,
            'mode_paiement' => $request->mode_paiement,
            'date_paiement' => $request->date_paiement,
            'reference'     => $request->reference,
            'note'          => $request->note,
        ]);

        $this->mettreAJourStatut($vente);

        return $paiement;
    }

    public function supprimer(Paiement $paiement): void
    {
        $vente = $paiement->vente;
        $paiement->delete();
        $this->mettreAJourStatut($vente);
    }

    private function mettreAJourStatut(Vente $vente): void
    {
        // Recharge les paiements depuis la DB pour avoir un total exact
        $vente->load('paiements');
        $montantPaye = $vente->montant_paye;
        $totalTtc    = (float) $vente->total_ttc;

        $statut = match(true) {
            $montantPaye <= 0             => 'non_paye',
            $montantPaye >= $totalTtc     => 'solde',
            default                       => 'partiel',
        };

        $vente->update(['statut_paiement' => $statut]);
    }
}
