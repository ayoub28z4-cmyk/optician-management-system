<?php

namespace App\Services;

use App\Events\StockRetire;
use App\Exceptions\QuantiteInsuffisanteException;
use App\Models\MouvementStock;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Enregistre un achat (entrée stock) et retourne le Produit.
     * Crée le produit si le triplet (societe, type_article, champ_reserve) est nouveau.
     */
    public function enregistrerAchat(
        int    $societeId,
        int    $typeArticleId,
        int    $designationId,
        int    $quantite,
        float  $prix,
        string $date
    ): Produit {
        return DB::transaction(function () use ($societeId, $typeArticleId, $designationId, $quantite, $prix, $date) {

            $produit = Produit::where('societe_id', $societeId)
                              ->where('type_article_id', $typeArticleId)
                              ->where('designation_id', $designationId)
                              ->lockForUpdate()
                              ->first();

            if ($produit === null) {
                $produit = Produit::create([
                    'societe_id'        => $societeId,
                    'type_article_id'   => $typeArticleId,
                    'designation_id'    => $designationId,
                    'quantite_stock'    => $quantite,
                    'prix_achat_actuel' => $prix,
                ]);
            } else {
                $produit->quantite_stock    += $quantite;
                $produit->prix_achat_actuel  = $prix;
                $produit->save();
            }

            MouvementStock::create([
                'produit_id'     => $produit->id,
                'type_mouvement' => 'achat',
                'quantite'       => $quantite,
                'prix_unitaire'  => $prix,
                'date_mouvement' => $date,
            ]);

            return $produit;
        });
    }

    /**
     * Retire du stock (vente / casse / retour).
     *
     * @throws QuantiteInsuffisanteException
     */
    public function retirer(Produit $produit, int $quantite, string $typeMouvement): MouvementStock
    {
        return DB::transaction(function () use ($produit, $quantite, $typeMouvement) {

            $produit = Produit::where('id', $produit->id)->lockForUpdate()->first();

            if ($produit->quantite_stock < $quantite) {
                throw new QuantiteInsuffisanteException($quantite, $produit->quantite_stock);
            }

            $produit->quantite_stock -= $quantite;
            $produit->save();

            $mouvement = MouvementStock::create([
                'produit_id'     => $produit->id,
                'type_mouvement' => $typeMouvement,
                'quantite'       => $quantite,
                'prix_unitaire'  => $produit->prix_achat_actuel,
                'date_mouvement' => now()->toDateString(),
            ]);

            StockRetire::dispatch($mouvement);

            return $mouvement;
        });
    }
}
