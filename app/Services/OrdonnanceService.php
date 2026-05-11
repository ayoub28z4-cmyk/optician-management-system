<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Ordonnance;
use App\Http\Requests\StoreOrdonnanceRequest;
use App\Http\Requests\UpdateOrdonnanceRequest;
use Illuminate\Support\Facades\Auth;


class OrdonnanceService
{
    public function listerParClient(Client $client)
    {
        return $client->ordonnances()->with('user')->paginate(8);
    }

    private function normaliserDecimaux(array $data): array
    {
        $champs = [
            'od_sphere', 'od_cylindre', 'od_axe',
            'og_sphere', 'og_cylindre', 'og_axe',
            'addition', 'ecart_pupillaire'
        ];
        foreach ($champs as $champ) {
            if (!empty($data[$champ])) {
                $data[$champ] = str_replace(',', '.', $data[$champ]);
            }
        }
        return $data;
    }

    public function creer(StoreOrdonnanceRequest $request): Ordonnance
    {
        $data = $request->validated();
        $data['user_id']   = Auth::id();
        $data['client_id'] = $request->client_id;
        $data = $this->normaliserDecimaux($data);

        $ordonnance = Ordonnance::create($data);

        // Générer automatiquement le rappel mutuelle
        app(\App\Services\RappelService::class)->genererDepuisOrdonnance($ordonnance);

        return $ordonnance;
    }

    public function modifier(UpdateOrdonnanceRequest $request, Ordonnance $ordonnance): Ordonnance
    {
        $data = $this->normaliserDecimaux($request->validated());
        $ordonnance->update($data);
        return $ordonnance;
    }

    public function supprimer(Ordonnance $ordonnance): void
    {
        $ordonnance->delete();
    }
}
