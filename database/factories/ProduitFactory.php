<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition(): array
    {
        $categorie = fake()->randomElement(['monture', 'verre', 'accessoire', 'prestation']);

        $designation = match ($categorie) {
            'monture' => fake()->randomElement([
                'Monture optique classique',
                'Monture métal homme',
                'Monture acétate femme',
                'Monture enfant',
                'Monture solaire',
            ]),
            'verre' => fake()->randomElement([
                'Verre simple foyer',
                'Verre progressif',
                'Verre anti-lumière bleue',
                'Verre photochromique',
                'Verre anti-reflet',
            ]),
            'accessoire' => fake()->randomElement([
                'Étui à lunettes',
                'Chiffonnette microfibre',
                'Spray nettoyant',
                'Cordon lunettes',
                'Boîte lentilles',
            ]),
            'prestation' => fake()->randomElement([
                'Réparation monture',
                'Montage verres',
                'Ajustement lunettes',
                'Contrôle visuel',
                'Nettoyage complet',
            ]),
        };

        $prixAchat = fake()->randomFloat(2, 20, 800);
        $prixVente = $prixAchat + fake()->randomFloat(2, 10, 300);

        return [
            'reference' => 'PRD-' . strtoupper(fake()->unique()->bothify('###??##')),
            'designation' => $designation,
            'categorie' => $categorie,
            'marque' => fake()->optional()->company(),
            'modele' => fake()->optional()->bothify('MOD-##??'),
            'prix_achat' => $prixAchat,
            'prix_vente' => $prixVente,
            'quantite_stock' => fake()->numberBetween(0, 50),
            'seuil_alerte' => fake()->numberBetween(1, 5),
            'is_active' => fake()->boolean(90),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
