<?php

namespace App\Http\Controllers;

use App\Models\MouvementStock;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyntheseRetraitsController extends Controller
{
    public function index(Request $request)
    {
        $dateDebut = $request->date_debut ?? now()->startOfMonth()->toDateString();
        $dateFin   = $request->date_fin   ?? now()->toDateString();

        // ─── A. ÉTAT ACTUEL DU STOCK (snapshot sans filtre date) ────────────

        $valeurStock = (float) Produit::selectRaw('COALESCE(SUM(quantite_stock * prix_achat_actuel), 0) as total')
            ->value('total');

        $totalSKUs  = Produit::count();
        $enRupture  = Produit::where('quantite_stock', 0)->count();
        $enAlerte   = Produit::where('quantite_stock', '>', 0)
                             ->whereColumn('quantite_stock', '<=', 'seuil_alerte')
                             ->count();
        $bienStocke = Produit::whereColumn('quantite_stock', '>', 'seuil_alerte')->count();

        // Liste articles en rupture (top 10 les plus récemment mis à jour)
        $articlesRupture = Produit::with(['societe', 'typeArticle', 'designation'])
            ->where('quantite_stock', 0)
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        // Liste articles sous seuil (stock > 0 mais <= seuil_alerte)
        $articlesSousSeuil = Produit::with(['societe', 'typeArticle', 'designation'])
            ->where('quantite_stock', '>', 0)
            ->whereColumn('quantite_stock', '<=', 'seuil_alerte')
            ->orderBy('quantite_stock')
            ->get();

        // Articles dormants : en stock mais aucun mouvement depuis 30 jours
        $limiteActivite = now()->subDays(30)->toDateString();
        $dormants = Produit::with(['societe', 'typeArticle', 'designation'])
            ->where('quantite_stock', '>', 0)
            ->whereDoesntHave('mouvements', fn($q) => $q->where('date_mouvement', '>=', $limiteActivite))
            ->orderByDesc('quantite_stock')
            ->limit(10)
            ->get();

        // ─── B. FLUX SUR LA PÉRIODE ──────────────────────────────────────────

        // Entrées (achats)
        $entreesBase   = MouvementStock::where('type_mouvement', 'achat')
            ->whereBetween('date_mouvement', [$dateDebut, $dateFin]);
        $nbEntrees     = (clone $entreesBase)->count();
        $qteEntrees    = (clone $entreesBase)->sum('quantite');
        $valeurEntrees = (float) (clone $entreesBase)
            ->selectRaw('COALESCE(SUM(quantite * prix_unitaire), 0) as total')
            ->value('total');

        // Sorties (vente + casse + retour)
        $sortiesBase = MouvementStock::whereIn('type_mouvement', ['vente', 'casse', 'retour'])
            ->whereBetween('date_mouvement', [$dateDebut, $dateFin]);
        $nbSorties   = (clone $sortiesBase)->count();
        $qteSorties  = (clone $sortiesBase)->sum('quantite');

        // Valeur des sorties (coût d'achat des articles sortis)
        $valeurSorties = (float) (clone $sortiesBase)
            ->selectRaw('COALESCE(SUM(quantite * prix_unitaire), 0) as total')
            ->value('total');

        // Détail par motif
        $parMotif = (clone $sortiesBase)
            ->select('type_mouvement', DB::raw('COUNT(*) as nb'), DB::raw('SUM(quantite) as qte'))
            ->groupBy('type_mouvement')
            ->get()
            ->keyBy('type_mouvement');

        // ─── C. TOP 5 ARTICLES SORTANTS ─────────────────────────────────────

        $topArticles = MouvementStock::with(['produit.societe', 'produit.typeArticle', 'produit.designation'])
            ->whereIn('type_mouvement', ['vente', 'casse', 'retour'])
            ->whereBetween('date_mouvement', [$dateDebut, $dateFin])
            ->select('produit_id', DB::raw('SUM(quantite) as total_sortie'), DB::raw('COUNT(*) as nb_mvt'))
            ->groupBy('produit_id')
            ->orderByDesc('total_sortie')
            ->limit(5)
            ->get();

        // ─── D. RÉPARTITIONS ─────────────────────────────────────────────────

        $parSociete = (clone $sortiesBase)
            ->join('produits', 'mouvements_stock.produit_id', '=', 'produits.id')
            ->join('societes', 'produits.societe_id', '=', 'societes.id')
            ->select(
                'societes.nom as societe',
                DB::raw('COUNT(*) as nb'),
                DB::raw('SUM(mouvements_stock.quantite) as qte')
            )
            ->groupBy('societes.nom')
            ->orderByDesc('qte')
            ->get();

        $parTypeArticle = (clone $sortiesBase)
            ->join('produits', 'mouvements_stock.produit_id', '=', 'produits.id')
            ->join('types_articles', 'produits.type_article_id', '=', 'types_articles.id')
            ->select(
                'types_articles.nom as type_article',
                DB::raw('COUNT(*) as nb'),
                DB::raw('SUM(mouvements_stock.quantite) as qte')
            )
            ->groupBy('types_articles.nom')
            ->orderByDesc('qte')
            ->get();

        // ─── E. JOURNAL COMPLET (entrées + sorties) ──────────────────────────

        $journal = MouvementStock::with(['produit.societe', 'produit.typeArticle', 'produit.designation'])
            ->whereBetween('date_mouvement', [$dateDebut, $dateFin])
            ->orderByDesc('date_mouvement')
            ->orderByDesc('id')
            ->limit(60)
            ->get();

        return view('retraits.synthese', compact(
            'dateDebut', 'dateFin',
            'valeurStock', 'totalSKUs', 'enRupture', 'enAlerte', 'bienStocke',
            'articlesRupture', 'articlesSousSeuil', 'dormants',
            'nbEntrees', 'qteEntrees', 'valeurEntrees',
            'nbSorties', 'qteSorties', 'valeurSorties', 'parMotif',
            'topArticles',
            'parSociete', 'parTypeArticle',
            'journal'
        ));
    }
}
