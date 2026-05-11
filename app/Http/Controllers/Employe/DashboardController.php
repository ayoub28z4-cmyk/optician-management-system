<?php

namespace App\Http\Controllers\Employe;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Vente;
use App\Models\RendezVous;
use App\Models\Rappel;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients  = Client::where('is_active', true)->count();
        $caAujourdhui  = Vente::whereDate('date_vente', today())->sum('total_ttc');
        $rdvAujourdhui = RendezVous::with('client')
                                    ->whereDate('date_heure', today())
                                    ->orderBy('date_heure')
                                    ->get();
        $rappelsUrgents = Rappel::with('client')
                                 ->whereIn('statut', ['a_contacter', 'contacte', 'relance'])
                                 ->where('date_rappel_prevu', '<=', now()->addDays(60))
                                 ->orderBy('date_rappel_prevu')
                                 ->limit(5)
                                 ->get();
        $dernieresVentes = Vente::with('client')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        return view('employe.dashboard', compact(
            'totalClients', 'caAujourdhui',
            'rdvAujourdhui', 'rappelsUrgents', 'dernieresVentes'
        ));
    }
}
