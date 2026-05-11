<?php

namespace App\Services;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{
    // Liste paginée avec recherche et filtres
    public function liste(array $filtres): LengthAwarePaginator
    {
        $query = Client::query()->where('is_active', true);

        if (!empty($filtres['search'])) {
            $search = $filtres['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%")
                  ->orWhere('classement_registre', 'like', "%{$search}%");
            });
        }

        if (!empty($filtres['type'])) {
            $query->where('type', $filtres['type']);
        }

        return $query->with('user')->orderBy('classement_registre')->paginate(10);
    }

    // Créer un client
    public function creer(StoreClientRequest $request): Client
    {
        return Client::create(array_merge($request->validated(), [
            'user_id' => auth()->id(),
        ]));
    }

    // Mettre à jour un client
    public function modifier(UpdateClientRequest $request, Client $client): Client
    {
        $client->update($request->validated());
        return $client;
    }

    // Désactiver un client
    public function desactiver(Client $client): void
    {
        $client->update(['is_active' => false]);
    }
}
