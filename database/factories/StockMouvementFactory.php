<?php

namespace Database\Factories;

use App\Models\Produit;
use App\Models\StockMouvement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockMouvement>
 */
class StockMouvementFactory extends Factory
{
    protected $model = StockMouvement::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['entree', 'sortie', 'ajustement']);
        $stockAvant = fake()->numberBetween(0, 100);
        $quantite = fake()->numberBetween(1, 20);

        if ($type === 'entree') {
            $stockApres = $stockAvant + $quantite;
        } elseif ($type === 'sortie') {
            $quantite = fake()->numberBetween(1, max(1, $stockAvant));
            $stockApres = $stockAvant - $quantite;
        } else {
            // ajustement : on fixe un stock après réaliste
            $stockApres = fake()->numberBetween(0, 100);
            $quantite = abs($stockApres - $stockAvant);
        }

        return [
            'produit_id' => Produit::query()->inRandomOrder()->value('id') ?? Produit::factory(),
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),

            'type' => $type,
            'quantite' => $quantite,
            'stock_avant' => $stockAvant,
            'stock_apres' => $stockApres,
            'motif' => fake()->optional()->randomElement([
                'Réapprovisionnement fournisseur',
                'Vente en magasin',
                'Correction de stock',
                'Produit endommagé',
                'Erreur inventaire',
                'Retour client',
            ]),
        ];
    }
}
