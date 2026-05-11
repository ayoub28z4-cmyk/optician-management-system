<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::withCount('produits')->orderBy('nom')->paginate(20);

        return view('designations.index', compact('designations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:designations,nom',
        ], [
            'nom.unique' => 'Cette désignation existe déjà.',
        ]);

        Designation::create(['nom' => trim($request->nom)]);

        return back()->with('success', 'Désignation ajoutée.');
    }

    public function destroy(Designation $designation)
    {
        if ($designation->produits()->exists()) {
            return back()->withErrors(['delete' => 'Impossible de supprimer : des articles utilisent cette désignation.']);
        }

        $designation->delete();

        return back()->with('success', 'Désignation supprimée.');
    }
}
