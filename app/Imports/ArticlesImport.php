<?php

namespace App\Imports;

use App\Models\Designation;
use App\Models\Societe;
use App\Models\TypeArticle;
use App\Services\StockService;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ArticlesImport implements ToCollection, WithHeadingRow
{
    public function __construct(private StockService $stockService)
    {
    }

    /**
     * Colonnes attendues : date | societe | type_article | designation | stock | prix_dachat
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $societe     = Societe::firstOrCreate(['nom' => trim($row['societe'])]);
            $type        = TypeArticle::firstOrCreate(['nom' => trim($row['type_article'] ?? $row['article'] ?? '')]);
            $designation = Designation::firstOrCreate(['nom' => trim($row['designation'] ?? $row['champ_reserve'] ?? '')]);

            $this->stockService->enregistrerAchat(
                societeId:     $societe->id,
                typeArticleId: $type->id,
                designationId: $designation->id,
                quantite:      (int) $row['stock'],
                prix:          (float) $row['prix_dachat'],
                date:          \Carbon\Carbon::parse($row['date'])->toDateString(),
            );
        }
    }
}
