<?php

namespace App\Http\Controllers\Opticien;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Vente;
use App\Models\Produit;
use App\Models\Rappel;
use App\Models\RendezVous;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs
        $totalClients    = Client::where('is_active', true)->count();
        $ventesAujourdhui = Vente::whereDate('date_vente', today())->get();
        $caAujourdhui    = $ventesAujourdhui->sum('total_ttc');
        $totalRappels    = Rappel::whereIn('statut', ['a_contacter', 'contacte', 'relance'])->count();
        $rappelsUrgents  = Rappel::whereIn('statut', ['a_contacter', 'contacte', 'relance'])
                                  ->where('date_rappel_prevu', '<=', now()->addDays(60))
                                  ->count();
        $stockFaible     = Produit::where('quantite_stock', '<=', 5)->count();

        // RDV du jour
        $rdvAujourdhui = RendezVous::with('client')
                                    ->whereDate('date_heure', today())
                                    ->orderBy('date_heure')
                                    ->get();

        // Rappels urgents
        $rappelsAContacter = Rappel::with('client')
                                    ->whereIn('statut', ['a_contacter', 'contacte', 'relance'])
                                    ->where('date_rappel_prevu', '<=', now()->addDays(60))
                                    ->orderBy('date_rappel_prevu')
                                    ->limit(5)
                                    ->get();

        // Dernières ventes — paiements chargés pour éviter N+1 sur montant_paye
        $dernieresVentes = Vente::with(['client', 'paiements'])
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        return view('opticien.dashboard', compact(
            'totalClients', 'caAujourdhui', 'ventesAujourdhui',
            'rappelsUrgents', 'totalRappels', 'stockFaible',
            'rdvAujourdhui', 'rappelsAContacter', 'dernieresVentes'
        ));
    }
}
