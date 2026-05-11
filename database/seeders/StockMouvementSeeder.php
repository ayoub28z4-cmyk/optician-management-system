<?php

namespace Database\Seeders;

use App\Models\Produit;
use App\Models\StockMouvement;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockMouvementSeeder extends Seeder
{
    public function run(): void
    {
        $produit = Produit::query()->first();
        $user = User::query()->first();

        if (! $produit || ! $user) {
            $this->command->warn('Veuillez seed d’abord les tables produits et users.');
            return;
        }

        // Exemple fixe
        StockMouvement::create([
            'produit_id' => $produit->id,
            'user_id' => $user->id,
            'type' => 'entree',
            'quantite' => 10,
            'stock_avant' => 5,
            'stock_apres' => 15,
            'motif' => 'Réapprovisionnement initial',
        ]);

        // Données aléatoires
        StockMouvement::factory()->count(30)->create();
    }
}
