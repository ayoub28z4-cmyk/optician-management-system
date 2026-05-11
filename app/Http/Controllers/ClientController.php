<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClientService;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(private ClientService $clientService) {}

    public function index(Request $request)
    {
        $clients = $this->clientService->liste($request->only(['search', 'type']));
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        $this->clientService->creer($request);
        return redirect()->route('clients.index')
                         ->with('success', 'Client enregistré avec succès.');
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->clientService->modifier($request, $client);
        return redirect()->route('clients.show', $client)
                         ->with('success', 'Client mis à jour.');
    }

    public function destroy(Client $client)
    {
        $this->clientService->desactiver($client);
        return redirect()->route('clients.index')
                         ->with('success', 'Client désactivé.');
    }
}
