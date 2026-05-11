<?php

namespace App\Exports;

use App\Models\MouvementStock;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MouvementsExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(
        private string $dateDebut,
        private string $dateFin
    ) {
    }

    public function query()
    {
        return MouvementStock::with(['produit.societe', 'produit.typeArticle'])
            ->where('type_mouvement', 'achat')
            ->whereBetween('date_mouvement', [$this->dateDebut, $this->dateFin])
            ->orderBy('date_mouvement');
    }

    public function headings(): array
    {
        return ['Date', 'Société', 'Type article', 'Désignation', 'Quantité', 'Prix achat (MAD)'];
    }

    public function map($mouvement): array
    {
        return [
            $mouvement->date_mouvement->format('d/m/Y'),
            $mouvement->produit->societe->nom,
            $mouvement->produit->typeArticle->nom,
            $mouvement->produit->champ_reserve,
            $mouvement->quantite,
            number_format($mouvement->prix_unitaire, 2, '.', ''),
        ];
    }
}
