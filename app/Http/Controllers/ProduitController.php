<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Services\ProduitService;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function __construct(private ProduitService $produitService) {}

    public function index(Request $request)
    {
        $produits = $this->produitService->liste($request->only(['search', 'categorie', 'stock_faible']));
        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(StoreProduitRequest $request)
    {
        $this->produitService->creer($request);
        return redirect()->route('produits.index')
                         ->with('success', 'Produit créé avec succès.');
    }

    public function show(Produit $produit)
    {
        $mouvements = $produit->stockMouvements()->with('user')->paginate(10);
        return view('produits.show', compact('produit', 'mouvements'));
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(UpdateProduitRequest $request, Produit $produit)
    {
        $this->produitService->modifier($request, $produit);
        return redirect()->route('produits.show', $produit)
                         ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Produit $produit)
    {
        $this->produitService->desactiver($produit);
        return redirect()->route('produits.index')
                         ->with('success', 'Produit désactivé.');
    }

    // Mouvement de stock
    public function mouvement(Request $request, Produit $produit)
    {
        $request->validate([
            'type'     => 'required|in:entree,sortie',
            'quantite' => 'required|integer|min:1',
            'motif'    => 'nullable|string|max:200',
        ]);

        $this->produitService->mouvement(
            $produit,
            $request->type,
            $request->quantite,
            $request->motif ?? ''
        );

        return redirect()->route('produits.show', $produit)
                         ->with('success', 'Mouvement de stock enregistré.');
    }
}
