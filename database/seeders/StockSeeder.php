<?php

namespace Database\Seeders;

use App\Models\MouvementStock;
use App\Models\Produit;
use App\Models\Societe;
use App\Models\TypeArticle;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $societes = [
            'Essilor', 'Ray-Ban', 'Silhouette', 'Oakley', 'Zeiss',
            'Hoya', 'Transitions', 'Lindberg', 'Maui Jim', 'Persol',
        ];

        $types = [
            'Montures adultes', 'Montures enfants', 'Verres unifocaux',
            'Verres progressifs', 'Lentilles', 'Étuis', 'Cordons',
            'Produits nettoyants', 'Accessoires', 'Lunettes solaires',
        ];

        $designations = [
            'Montures adultes'     => ['Titanium noir mat', 'Acétate écaille', 'Métal doré', 'Aviateur argenté', 'Rectangulaire bleu', 'Ovale rose', 'Carré bordeaux', 'Demi-lune chrome'],
            'Montures enfants'     => ['Flexible bleu', 'Rose paillettes', 'Rouge sport', 'Vert pomme', 'Violet souple', 'Orange fun'],
            'Verres unifocaux'     => ['1.50 blanc', '1.60 blanc', '1.67 blanc', '1.50 antireflet', '1.60 antireflet', '1.74 ultra-mince'],
            'Verres progressifs'   => ['1.50 standard', '1.60 standard', '1.67 premium', '1.74 ultra', 'Digitaux 1.60', 'Digitaux 1.67'],
            'Lentilles'            => ['Journalières sphériques', 'Mensuelles sphériques', 'Toriques journalières', 'Multifocales mensuelles', 'Colorées vertes', 'Colorées bleues'],
            'Étuis'                => ['Rigide noir', 'Souple cuir', 'Rigide coloré', 'Compact pliant'],
            'Cordons'              => ['Silicone transparent', 'Cuir marron', 'Tissu coloré', 'Néoprène sport'],
            'Produits nettoyants'  => ['Spray 30ml', 'Spray 100ml', 'Lingettes x50', 'Kit complet'],
            'Accessoires'          => ['Chiffon microfibre', 'Tournevis kit', 'Plaquettes silicone', 'Colle rapide'],
            'Lunettes solaires'    => ['Polarisées noires', 'Miroir bleu', 'Dégradé gris', 'Marron polarisé', 'Sport wrap'],
        ];

        foreach ($societes as $nom) {
            Societe::firstOrCreate(['nom' => $nom]);
        }

        foreach ($types as $nom) {
            TypeArticle::firstOrCreate(['nom' => $nom]);
        }

        $societeIds    = Societe::pluck('id')->toArray();
        $typeMap       = TypeArticle::pluck('id', 'nom')->toArray();

        foreach ($designations as $typeNom => $items) {
            $typeId = $typeMap[$typeNom] ?? null;
            if (!$typeId) continue;

            foreach ($items as $champ) {
                $societeId = $societeIds[array_rand($societeIds)];
                $quantite  = rand(3, 50);
                $prix      = round(rand(50, 2500) + (rand(0, 99) / 100), 2);
                $date      = now()->subDays(rand(1, 180))->toDateString();

                $produit = Produit::firstOrCreate(
                    ['societe_id' => $societeId, 'type_article_id' => $typeId, 'champ_reserve' => $champ],
                    ['quantite_stock' => $quantite, 'prix_achat_actuel' => $prix]
                );

                if ($produit->wasRecentlyCreated) {
                    MouvementStock::create([
                        'produit_id'     => $produit->id,
                        'type_mouvement' => 'achat',
                        'quantite'       => $quantite,
                        'prix_unitaire'  => $prix,
                        'date_mouvement' => $date,
                    ]);

                    // Quelques retraits aléatoires
                    if (rand(0, 1) && $produit->quantite_stock >= 3) {
                        $retrait = rand(1, min(5, $produit->quantite_stock));
                        $motifs  = ['vente', 'vente', 'vente', 'casse', 'retour'];
                        $motif   = $motifs[array_rand($motifs)];

                        $produit->quantite_stock -= $retrait;
                        $produit->save();

                        MouvementStock::create([
                            'produit_id'     => $produit->id,
                            'type_mouvement' => $motif,
                            'quantite'       => $retrait,
                            'prix_unitaire'  => null,
                            'date_mouvement' => now()->subDays(rand(0, 30))->toDateString(),
                        ]);
                    }
                }
            }
        }

        $this->command->info('✓ Stock rempli : ' . Produit::count() . ' articles, ' . MouvementStock::count() . ' mouvements.');
    }
}
