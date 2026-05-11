<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Ordonnance;
use App\Services\OrdonnanceService;
use App\Http\Requests\StoreOrdonnanceRequest;
use App\Http\Requests\UpdateOrdonnanceRequest;

class OrdonnanceController extends Controller
{
    public function __construct(private OrdonnanceService $ordonnanceService) {}

    public function index(Client $client)
    {
        $ordonnances = $this->ordonnanceService->listerParClient($client);
        return view('ordonnances.index', compact('client', 'ordonnances'));
    }

    public function create(Client $client)
    {
        return view('ordonnances.create', compact('client'));
    }

    public function store(StoreOrdonnanceRequest $request, Client $client)
    {
        $request->merge(['client_id' => $client->id]);
        $this->ordonnanceService->creer($request);
        return redirect()->route('clients.ordonnances.index', $client)
                        ->with('success', 'Ordonnance enregistrée avec succès.');
    }

    public function show(Client $client, Ordonnance $ordonnance)
    {
        return view('ordonnances.show', compact('client', 'ordonnance'));
    }

    public function edit(Client $client, Ordonnance $ordonnance)
    {
        return view('ordonnances.edit', compact('client', 'ordonnance'));
    }

    public function update(UpdateOrdonnanceRequest $request, Client $client, Ordonnance $ordonnance)
    {
        $this->ordonnanceService->modifier($request, $ordonnance);
        return redirect()->route('clients.ordonnances.show', [$client, $ordonnance])
                        ->with('success', 'Ordonnance mise à jour.');
    }

    public function destroy(Client $client, Ordonnance $ordonnance)
    {
        $this->ordonnanceService->supprimer($ordonnance);
        return redirect()->route('clients.ordonnances.index', $client)
                         ->with('success', 'Ordonnance supprimée.');
    }
}
