<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Paiement;
use App\Services\PaiementService;
use App\Http\Requests\StorePaiementRequest;

class PaiementController extends Controller
{
    public function __construct(private PaiementService $paiementService) {}

    public function store(StorePaiementRequest $request, Vente $vente)
    {
        $this->paiementService->enregistrer($request, $vente);
        return redirect()->route('ventes.show', $vente)
                         ->with('success', 'Paiement enregistré avec succès.');
    }

    public function destroy(Vente $vente, Paiement $paiement)
    {
        abort_if($paiement->vente_id !== $vente->id, 403);

        $this->paiementService->supprimer($paiement);
        return redirect()->route('ventes.show', $vente)
                         ->with('success', 'Paiement supprimé.');
    }
}
