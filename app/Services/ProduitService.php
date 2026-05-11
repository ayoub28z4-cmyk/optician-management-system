<?php

namespace App\Services;

use App\Models\Produit;
use App\Models\StockMouvement;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ProduitService
{
    // Liste paginée avec filtres
    public function liste(array $filtres): LengthAwarePaginator
    {
        $query = Produit::query()->where('is_active', true);

        if (!empty($filtres['search'])) {
            $search = $filtres['search'];
            $query->where(function ($q) use ($search) {
                $q->where('designation', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhere('marque', 'like', "%{$search}%");
            });
        }

        if (!empty($filtres['categorie'])) {
            $query->where('categorie', $filtres['categorie']);
        }

        if (!empty($filtres['stock_faible'])) {
            $query->whereRaw('quantite_stock <= seuil_alerte');
        }

        return $query->orderBy('designation')->paginate(10);
    }

    // Créer un produit
    public function creer(StoreProduitRequest $request): Produit
    {
        $produit = Produit::create($request->validated());

        // Enregistrer mouvement stock initial
        if ($produit->quantite_stock > 0) {
            StockMouvement::create([
                'produit_id'  => $produit->id,
                'user_id'     => Auth::id(),
                'type'        => 'entree',
                'quantite'    => $produit->quantite_stock,
                'stock_avant' => 0,
                'stock_apres' => $produit->quantite_stock,
                'motif'       => 'Stock initial',
            ]);
        }

        return $produit;
    }

    // Modifier un produit
    public function modifier(UpdateProduitRequest $request, Produit $produit): Produit
    {
        $ancienStock = $produit->quantite_stock;
        $produit->update($request->validated());

        // Si stock modifié → enregistrer mouvement
        if ($ancienStock !== $produit->quantite_stock) {
            $diff = $produit->quantite_stock - $ancienStock;
            StockMouvement::create([
                'produit_id'  => $produit->id,
                'user_id'     => Auth::id(),
                'type'        => 'ajustement',
                'quantite'    => abs($diff),
                'stock_avant' => $ancienStock,
                'stock_apres' => $produit->quantite_stock,
                'motif'       => 'Ajustement manuel',
            ]);
        }

        return $produit;
    }

    // Mouvement de stock manuel
    public function mouvement(Produit $produit, string $type, int $quantite, string $motif = ''): void
    {
        $stockAvant = $produit->quantite_stock;

        if ($type === 'entree') {
            $stockApres = $stockAvant + $quantite;
        } else {
            $stockApres = max(0, $stockAvant - $quantite);
        }

        $produit->update(['quantite_stock' => $stockApres]);

        StockMouvement::create([
            'produit_id'  => $produit->id,
            'user_id'     => Auth::id(),
            'type'        => $type,
            'quantite'    => $quantite,
            'stock_avant' => $stockAvant,
            'stock_apres' => $stockApres,
            'motif'       => $motif,
        ]);
    }

    // Désactiver un produit
    public function desactiver(Produit $produit): void
    {
        $produit->update(['is_active' => false]);
    }
}
