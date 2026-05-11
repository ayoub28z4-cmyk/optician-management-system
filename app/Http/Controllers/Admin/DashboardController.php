<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Vente;
use App\Models\Produit;
use App\Models\Rappel;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients    = Client::where('is_active', true)->count();
        $totalUsers      = User::where('is_active', true)->count();
        $caTotal         = Vente::sum('total_ttc');
        $caMois          = Vente::whereMonth('date_vente', now()->month)
                                 ->whereYear('date_vente', now()->year)
                                 ->sum('total_ttc');
        $ventesNonPayees = Vente::where('statut_paiement', 'non_paye')->count();
        $stockFaible     = Produit::where('quantite_stock', '<=', 5)->count();
        $rappelsUrgents  = Rappel::whereIn('statut', ['a_contacter', 'contacte', 'relance'])
                                  ->where('date_rappel_prevu', '<=', now()->addDays(60))
                                  ->count();
        $dernieresVentes = Vente::with('client')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(8)
                                 ->get();
        // Répartition par mutuelle
        $repartitionMutuelle = \App\Models\Client::where('is_active', true)
            ->selectRaw('mutuelle_type, COUNT(*) as total')
            ->groupBy('mutuelle_type')
            ->get()
            ->mapWithKeys(fn($item) => [$item->mutuelle_type => $item->total]);

        return view('admin.dashboard', compact(
            'totalClients', 'totalUsers', 'caTotal', 'caMois',
            'ventesNonPayees', 'stockFaible', 'rappelsUrgents',
            'dernieresVentes', 'repartitionMutuelle'
        ));
    }
}
