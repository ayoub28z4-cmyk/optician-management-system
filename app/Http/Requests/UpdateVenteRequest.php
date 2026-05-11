<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ordonnance_id' => 'nullable|exists:ordonnances,id',
            'date_vente'    => 'required|date',
            'remise'        => 'nullable|numeric|min:0|max:100',
            'remarque'      => 'nullable|string',
            'statut_paiement' => 'nullable|in:non_paye,partiel,solde',
        ];
    }
}
