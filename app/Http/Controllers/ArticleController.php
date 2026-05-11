<?php

namespace App\Http\Controllers;

use App\Exceptions\QuantiteInsuffisanteException;
use App\Exports\MouvementsExport;
use App\Imports\ArticlesImport;
use App\Models\Designation;
use App\Models\Produit;
use App\Models\Societe;
use App\Models\TypeArticle;
use App\Http\Requests\CreerArticleRequest;
use App\Http\Requests\ModifierArticleRequest;
use App\Http\Requests\RetirerStockRequest;
use App\Services\StockService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ArticleController extends Controller
{
    public function __construct(private StockService $stockService)
    {
    }

    // ─── Listing ────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Produit::with(['societe', 'typeArticle', 'designation'])
            ->orderBy('quantite_stock', 'asc')
            ->orderBy('id', 'desc');

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('champ_reserve', 'like', "%{$search}%")
                  ->orWhereHas('societe', fn($s) => $s->where('nom', 'like', "%{$search}%"))
                  ->orWhereHas('typeArticle', fn($t) => $t->where('nom', 'like', "%{$search}%"));
            });
        }

        match ($request->filtre) {
            'rupture' => $query->where('quantite_stock', 0),
            'alerte'  => $query->where('quantite_stock', '>', 0)->whereColumn('quantite_stock', '<=', 'seuil_alerte'),
            default   => null,
        };

        $nbRupture = Produit::where('quantite_stock', 0)->count();
        $nbAlerte  = Produit::where('quantite_stock', '>', 0)->whereColumn('quantite_stock', '<=', 'seuil_alerte')->count();

        $articles = $query->paginate(15)->withQueryString();

        return view('articles.index', compact('articles', 'nbRupture', 'nbAlerte'));
    }

    // ─── Création ───────────────────────────────────────────────────────────

    public function create()
    {
        $societes      = Societe::orderBy('nom')->get();
        $typesArticles = TypeArticle::orderBy('nom')->get();
        $designations  = Designation::orderBy('nom')->get();

        return view('articles.create', compact('societes', 'typesArticles', 'designations'));
    }

    public function store(CreerArticleRequest $request)
    {
        // Création à la volée si l'utilisateur saisit une nouvelle désignation
        if ($request->designation_id === 'new') {
            $designation = Designation::firstOrCreate(['nom' => trim($request->nouvelle_designation)]);
            $designationId = $designation->id;
        } else {
            $designationId = (int) $request->designation_id;
        }

        $produit = $this->stockService->enregistrerAchat(
            societeId:     $request->societe_id,
            typeArticleId: $request->type_article_id,
            designationId: $designationId,
            quantite:      $request->quantite,
            prix:          $request->prix_achat,
            date:          $request->date,
        );

        $message = $produit->wasRecentlyCreated
            ? 'Nouveau produit créé et stock enregistré.'
            : 'Stock réapprovisionné sur le produit existant.';

        return redirect()->route('articles.index')->with('success', $message);
    }

    // ─── Édition ────────────────────────────────────────────────────────────

    public function edit(Produit $article)
    {
        $article->load(['societe', 'typeArticle', 'designation']);
        $societes      = Societe::orderBy('nom')->get();
        $typesArticles = TypeArticle::orderBy('nom')->get();
        $designations  = Designation::orderBy('nom')->get();

        return view('articles.edit', compact('article', 'societes', 'typesArticles', 'designations'));
    }

    public function update(ModifierArticleRequest $request, Produit $article)
    {
        $article->update([
            'societe_id'        => $request->societe_id,
            'type_article_id'   => $request->type_article_id,
            'designation_id'    => $request->designation_id,
            'prix_achat_actuel' => $request->prix_achat_actuel,
            'seuil_alerte'      => $request->seuil_alerte,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article mis à jour.');
    }

    public function destroy(Produit $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé.');
    }

    // ─── Retrait de stock ────────────────────────────────────────────────────

    public function retirerForm(Produit $article)
    {
        $article->load(['societe', 'typeArticle', 'designation']);

        return view('articles.retirer', compact('article'));
    }

    public function retirer(RetirerStockRequest $request, Produit $article)
    {
        try {
            $this->stockService->retirer($article, $request->quantite, $request->motif);
        } catch (QuantiteInsuffisanteException $e) {
            return back()->withErrors(['quantite' => $e->getMessage()]);
        }

        return redirect()->route('articles.index')
            ->with('success', 'Retrait de stock enregistré.');
    }

    // ─── Sélection retrait en 2 étapes ──────────────────────────────────────

    public function retraitSelectionForm(Request $request)
    {
        $typesArticles = TypeArticle::orderBy('nom')->get();
        $typeArticle   = null;
        $articles      = collect();

        if ($request->filled('type_article_id')) {
            $typeArticle = TypeArticle::findOrFail($request->type_article_id);
            $articles    = Produit::with(['societe', 'designation'])
                ->where('type_article_id', $typeArticle->id)
                ->where('quantite_stock', '>', 0)
                ->orderBy('designation_id')
                ->get();
        }

        return view('articles.retrait-selection', compact('typesArticles', 'typeArticle', 'articles'));
    }

    public function retraitSelection(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:produits,id',
        ]);

        return redirect()->route('articles.retirer.form', $request->article_id);
    }

    // ─── Import / Export Excel ───────────────────────────────────────────────

    public function importer(Request $request)
    {
        $request->validate(['fichier' => 'required|file|mimes:xlsx,xls,csv']);

        Excel::import(new ArticlesImport($this->stockService), $request->file('fichier'));

        return back()->with('success', 'Import effectué avec succès.');
    }

    public function exporter(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',
        ]);

        $nom = 'achats_' . $request->date_debut . '_' . $request->date_fin . '.xlsx';

        return Excel::download(
            new MouvementsExport($request->date_debut, $request->date_fin),
            $nom
        );
    }
}
