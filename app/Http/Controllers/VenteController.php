<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Client;
use App\Models\Produit;
use App\Services\VenteService;
use App\Http\Requests\StoreVenteRequest;
use App\Http\Requests\UpdateVenteRequest;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function __construct(private VenteService $venteService) {}

    public function index(Request $request)
    {
        $ventes = $this->venteService->liste($request->only(['search', 'statut']));
        return view('ventes.index', compact('ventes'));
    }

    public function create(Request $request)
    {
        $clients  = Client::where('is_active', true)->orderBy('nom')->get();
        $produits = Produit::with(['societe', 'typeArticle', 'designation'])
                           ->where('quantite_stock', '>', 0)
                           ->orderBy('designation_id')
                           ->get();
        $client   = $request->client_id ? Client::find($request->client_id) : null;
        return view('ventes.create', compact('clients', 'produits', 'client'));
    }

    public function store(StoreVenteRequest $request)
    {
        try {
            $vente = $this->venteService->creer($request);
        } catch (\RuntimeException $e) {
            return back()->withInput()->withErrors(['lignes' => $e->getMessage()]);
        }

        return redirect()->route('ventes.show', $vente)
                         ->with('success', 'Vente enregistrée — Facture ' . $vente->numero_facture);
    }

    public function show(Vente $vente)
    {
        $vente->load(['client', 'user', 'ordonnance', 'lignes.produit']);
        return view('ventes.show', compact('vente'));
    }

    public function edit(Vente $vente)
    {
        return view('ventes.edit', compact('vente'));
    }

    public function update(UpdateVenteRequest $request, Vente $vente)
    {
        $this->venteService->modifier($request, $vente);
        return redirect()->route('ventes.show', $vente)
                         ->with('success', 'Vente mise à jour.');
    }

    public function print(Vente $vente)
    {
        $vente->load(['client', 'user', 'ordonnance', 'lignes.produit']);
        return view('ventes.print', compact('vente'));
    }
}
