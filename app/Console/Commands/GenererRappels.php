<?php

namespace App\Console\Commands;

use App\Models\Ordonnance;
use App\Services\RappelService;
use Illuminate\Console\Command;

class GenererRappels extends Command
{
    protected $signature   = 'rappels:generer';
    protected $description = 'Générer les rappels mutuelle pour toutes les ordonnances sans rappel';

    public function handle(RappelService $rappelService): void
    {
        $this->info('Génération des rappels en cours...');

        $ordonnances = Ordonnance::whereDoesntHave('rappel')->get();
        $count = 0;

        foreach ($ordonnances as $ordonnance) {
            $rappel = $rappelService->genererDepuisOrdonnance($ordonnance);
            if ($rappel) {
                $count++;
                $this->line("  ✓ Rappel créé pour {$ordonnance->client->nom_complet}");
            }
        }

        $this->info("✅ {$count} rappel(s) générés sur {$ordonnances->count()} ordonnance(s) traitées.");
    }
}
