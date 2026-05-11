<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'      => 'required|exists:clients,id',
            'ordonnance_id'  => 'nullable|exists:ordonnances,id',
            'date_vente'     => 'required|date',
            'remise'         => 'nullable|numeric|min:0|max:100',
            'remarque'       => 'nullable|string',

            // Lignes de vente
            'lignes'                    => 'required|array|min:1',
            'lignes.*.produit_id'       => 'nullable|exists:produits,id',
            'lignes.*.designation'      => 'required|string|max:200',
            'lignes.*.quantite'         => 'required|integer|min:1',
            'lignes.*.prix_unitaire'    => 'required|numeric|min:0',
            'lignes.*.remise_ligne'     => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required'            => 'Le client est obligatoire.',
            'date_vente.required'           => 'La date de vente est obligatoire.',
            'lignes.required'               => 'Ajoutez au moins une ligne de produit.',
            'lignes.min'                    => 'Ajoutez au moins une ligne de produit.',
            'lignes.*.designation.required' => 'La désignation est obligatoire.',
            'lignes.*.quantite.required'    => 'La quantité est obligatoire.',
            'lignes.*.prix_unitaire.required' => 'Le prix est obligatoire.',
        ];
    }
}
