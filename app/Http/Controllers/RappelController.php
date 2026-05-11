<?php

namespace App\Http\Controllers;

use App\Models\Rappel;
use App\Services\RappelService;
use Illuminate\Http\Request;

class RappelController extends Controller
{
    public function __construct(private RappelService $rappelService) {}

    public function index(Request $request)
    {
        $rappels = $this->rappelService->liste($request->only(['statut', 'urgence']));
        return view('rappels.index', compact('rappels'));
    }

    public function update(Request $request, Rappel $rappel)
    {
        $request->validate([
            'statut'       => 'required|in:a_contacter,contacte,relance,traite',
            'note_contact' => 'nullable|string',
        ]);

        $this->rappelService->mettreAJourStatut(
            $rappel,
            $request->statut,
            $request->note_contact
        );

        return redirect()->route('rappels.index')
                         ->with('success', 'Rappel mis à jour.');
    }
}
