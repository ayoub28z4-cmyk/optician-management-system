<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        // Exemples fixes
        Produit::create([
            'reference' => 'PRD-001MT',
            'designation' => 'Monture optique classique',
            'categorie' => 'monture',
            'marque' => 'Ray-Ban',
            'modele' => 'RB-Optic-01',
            'prix_achat' => 250.00,
            'prix_vente' => 420.00,
            'quantite_stock' => 12,
            'seuil_alerte' => 2,
            'is_active' => true,
            'description' => 'Monture légère et résistante.',
        ]);

        Produit::create([
            'reference' => 'PRD-002VR',
            'designation' => 'Verre anti-reflet',
            'categorie' => 'verre',
            'marque' => 'Essilor',
            'modele' => 'AR-2026',
            'prix_achat' => 180.00,
            'prix_vente' => 320.00,
            'quantite_stock' => 20,
            'seuil_alerte' => 3,
            'is_active' => true,
            'description' => 'Verre traité anti-reflet.',
        ]);

        Produit::create([
            'reference' => 'PRD-003AC',
            'designation' => 'Étui à lunettes',
            'categorie' => 'accessoire',
            'marque' => null,
            'modele' => 'ETUI-01',
            'prix_achat' => 15.00,
            'prix_vente' => 35.00,
            'quantite_stock' => 30,
            'seuil_alerte' => 5,
            'is_active' => true,
            'description' => 'Étui rigide de protection.',
        ]);

        Produit::create([
            'reference' => 'PRD-004PS',
            'designation' => 'Montage verres',
            'categorie' => 'prestation',
            'marque' => null,
            'modele' => null,
            'prix_achat' => 0,
            'prix_vente' => 80.00,
            'quantite_stock' => 0,
            'seuil_alerte' => 0,
            'is_active' => true,
            'description' => 'Service de montage de verres.',
        ]);

        Produit::factory()->count(30)->create();
    }
}
