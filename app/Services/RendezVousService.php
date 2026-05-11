<?php

namespace App\Services;

use App\Models\RendezVous;
use App\Http\Requests\StoreRendezVousRequest;
use App\Http\Requests\UpdateRendezVousRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class RendezVousService
{
    public function liste(array $filtres): LengthAwarePaginator
    {
        $query = RendezVous::with(['client', 'user'])
                           ->orderBy('date_heure', 'asc');

        if (!empty($filtres['date'])) {
            $query->whereDate('date_heure', $filtres['date']);
        } else {
            $query->whereDate('date_heure', '>=', now()->toDateString());
        }

        if (!empty($filtres['statut'])) {
            $query->where('statut', $filtres['statut']);
        }

        return $query->paginate(10);
    }

    public function aujourdhui(): \Illuminate\Database\Eloquent\Collection
    {
        return RendezVous::with('client')
                         ->whereDate('date_heure', today())
                         ->orderBy('date_heure', 'asc')
                         ->get();
    }

    public function creer(StoreRendezVousRequest $request): RendezVous
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['statut']  = $data['statut'] ?? 'planifie';
        return RendezVous::create($data);
    }

    public function modifier(UpdateRendezVousRequest $request, RendezVous $rendezVous): RendezVous
    {
        $rendezVous->update($request->validated());
        return $rendezVous;
    }

    public function supprimer(RendezVous $rendezVous): void
    {
        $rendezVous->delete();
    }
}
