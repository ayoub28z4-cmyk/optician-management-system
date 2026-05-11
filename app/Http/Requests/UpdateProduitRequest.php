<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference'      => 'required|string|max:50|unique:produits,reference,' . $this->produit->id,
            'designation'    => 'required|string|max:200',
            'categorie'      => 'required|in:monture,verre,accessoire,prestation',
            'marque'         => 'nullable|string|max:100',
            'modele'         => 'nullable|string|max:100',
            'prix_achat'     => 'required|numeric|min:0',
            'prix_vente'     => 'required|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            'seuil_alerte'   => 'required|integer|min:0',
            'description'    => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'reference.required'   => 'La référence est obligatoire.',
            'reference.unique'     => 'Cette référence existe déjà.',
            'designation.required' => 'La désignation est obligatoire.',
            'categorie.required'   => 'La catégorie est obligatoire.',
            'prix_achat.required'  => 'Le prix d\'achat est obligatoire.',
            'prix_vente.required'  => 'Le prix de vente est obligatoire.',
        ];
    }
}
