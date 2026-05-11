<?php

namespace App\Services;

use App\Models\Vente;
use App\Models\VenteLigne;
use App\Models\StockMouvement;
use App\Http\Requests\StoreVenteRequest;
use App\Http\Requests\UpdateVenteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VenteService
{
    public function liste(array $filtres)
    {
        $query = Vente::with(['client', 'user'])
                      ->orderBy('created_at', 'desc');

        if (!empty($filtres['search'])) {
            $search = $filtres['search'];
            $query->where(function ($q) use ($search) {
                $q->where('numero_facture', 'like', "%{$search}%")
                  ->orWhereHas('client', fn($c) =>
                      $c->where('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%")
                  );
            });
        }

        if (!empty($filtres['statut'])) {
            $query->where('statut_paiement', $filtres['statut']);
        }

        return $query->paginate(10);
    }

    public function creer(StoreVenteRequest $request): Vente
    {
        return DB::transaction(function () use ($request) {

            // Calculer totaux
            $lignes    = $request->lignes;
            $remise    = $request->remise ?? 0;
            $totalHt   = 0;

            foreach ($lignes as $ligne) {
                $sousTotal  = $ligne['quantite'] * $ligne['prix_unitaire'];
                $remiseLigne = $ligne['remise_ligne'] ?? 0;
                $sousTotal  = $sousTotal * (1 - $remiseLigne / 100);
                $totalHt   += $sousTotal;
            }

            $totalTtc = $totalHt * (1 - $remise / 100);

            // Créer la vente
            $vente = Vente::create([
                'client_id'       => $request->client_id,
                'user_id'         => Auth::id(),
                'ordonnance_id'   => $request->ordonnance_id,
                'numero_facture'  => Vente::genererNumeroFacture(),
                'date_vente'      => $request->date_vente,
                'remise'          => $remise,
                'total_ht'        => round($totalHt, 2),
                'total_ttc'       => round($totalTtc, 2),
                'statut_paiement' => 'non_paye',
                'remarque'        => $request->remarque,
            ]);

            // Créer les lignes + décrémenter stock
            foreach ($lignes as $ligne) {
                $sousTotal   = $ligne['quantite'] * $ligne['prix_unitaire'];
                $remiseLigne = $ligne['remise_ligne'] ?? 0;
                $sousTotal   = $sousTotal * (1 - $remiseLigne / 100);

                VenteLigne::create([
                    'vente_id'      => $vente->id,
                    'produit_id'    => $ligne['produit_id'] ?? null,
                    'designation'   => $ligne['designation'],
                    'quantite'      => $ligne['quantite'],
                    'prix_unitaire' => $ligne['prix_unitaire'],
                    'remise_ligne'  => $remiseLigne,
                    'sous_total'    => round($sousTotal, 2),
                ]);

                // Décrémenter stock si produit stocké
                if (!empty($ligne['produit_id'])) {
                    $produit = \App\Models\Produit::lockForUpdate()->find($ligne['produit_id']);
                    if ($produit) {
                        if ($produit->quantite_stock < $ligne['quantite']) {
                            throw new \RuntimeException(
                                "Stock insuffisant pour « {$produit->champ_reserve} » : " .
                                "{$produit->quantite_stock} disponible(s), {$ligne['quantite']} demandé(s)."
                            );
                        }
                        $stockAvant = $produit->quantite_stock;
                        $stockApres = $stockAvant - $ligne['quantite'];
                        $produit->update(['quantite_stock' => $stockApres]);

                        StockMouvement::create([
                            'produit_id'  => $produit->id,
                            'user_id'     => Auth::id(),
                            'type'        => 'sortie',
                            'quantite'    => $ligne['quantite'],
                            'stock_avant' => $stockAvant,
                            'stock_apres' => $stockApres,
                            'motif'       => 'Vente ' . $vente->numero_facture,
                        ]);
                    }
                }
            }

            return $vente;
        });
    }

    public function modifier(UpdateVenteRequest $request, Vente $vente): Vente
    {
        $vente->update($request->validated());
        return $vente;
    }
}
