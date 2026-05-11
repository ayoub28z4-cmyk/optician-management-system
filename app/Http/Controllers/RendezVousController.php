<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\RendezVous;
use App\Services\RendezVousService;
use App\Http\Requests\StoreRendezVousRequest;
use App\Http\Requests\UpdateRendezVousRequest;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    public function __construct(private RendezVousService $rendezVousService) {}

    public function index(Request $request)
    {
        $rendezVous  = $this->rendezVousService->liste($request->only(['date', 'statut']));
        $aujourdhui  = $this->rendezVousService->aujourdhui();
        return view('rendez-vous.index', compact('rendezVous', 'aujourdhui'));
    }

    public function create(Request $request)
    {
        $clients = Client::where('is_active', true)->orderBy('nom')->get();
        $client  = $request->client_id ? Client::find($request->client_id) : null;
        return view('rendez-vous.create', compact('clients', 'client'));
    }

    public function store(StoreRendezVousRequest $request)
    {
        $this->rendezVousService->creer($request);
        return redirect()->route('rendez-vous.index')
                         ->with('success', 'Rendez-vous enregistré avec succès.');
    }

    public function edit(RendezVous $rendezVous)
    {
        return view('rendez-vous.edit', compact('rendezVous'));
    }

    public function update(UpdateRendezVousRequest $request, RendezVous $rendezVous)
    {
        $this->rendezVousService->modifier($request, $rendezVous);
        return redirect()->route('rendez-vous.index')
                         ->with('success', 'Rendez-vous mis à jour.');
    }

    public function destroy(RendezVous $rendezVous)
    {
        $this->rendezVousService->supprimer($rendezVous);
        return redirect()->route('rendez-vous.index')
                         ->with('success', 'Rendez-vous supprimé.');
    }
}
