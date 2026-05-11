<?php

namespace App\Http\Controllers;

use App\Models\Societe;
use Illuminate\Http\Request;

class SocieteController extends Controller
{
    public function index()
    {
        $societes = Societe::withCount('produits')->orderBy('nom')->paginate(20);

        return view('societes.index', compact('societes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:societes,nom',
        ]);

        Societe::create(['nom' => $request->nom]);

        return back()->with('success', 'Société / marque ajoutée.');
    }

    public function destroy(Societe $societe)
    {
        if ($societe->produits()->exists()) {
            return back()->withErrors(['nom' => 'Impossible de supprimer : des produits sont liés à cette société.']);
        }

        $societe->delete();

        return back()->with('success', 'Société supprimée.');
    }
}
