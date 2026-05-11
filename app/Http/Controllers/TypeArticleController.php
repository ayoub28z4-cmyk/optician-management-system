<?php

namespace App\Http\Controllers;

use App\Models\TypeArticle;
use Illuminate\Http\Request;

class TypeArticleController extends Controller
{
    public function index()
    {
        $typesArticles = TypeArticle::withCount('produits')->orderBy('nom')->paginate(20);

        return view('types-articles.index', compact('typesArticles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:types_articles,nom',
        ], [
            'nom.unique' => 'Ce type d\'article existe déjà.',
        ]);

        TypeArticle::create(['nom' => trim($request->nom)]);

        return back()->with('success', 'Type d\'article ajouté.');
    }

    public function destroy(TypeArticle $typesArticle)
    {
        if ($typesArticle->produits()->exists()) {
            return back()->withErrors(['delete' => 'Impossible de supprimer : des articles utilisent ce type.']);
        }

        $typesArticle->delete();

        return back()->with('success', 'Type d\'article supprimé.');
    }
}
