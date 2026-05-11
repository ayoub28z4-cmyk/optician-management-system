<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaiementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $modeAvecRef = in_array($this->mode_paiement, ['cheque', 'virement']);

        return [
            'montant'       => 'required|numeric|min:0.01',
            'mode_paiement' => 'required|in:especes,cheque,virement,carte',
            'date_paiement' => 'required|date',
            'reference'     => $modeAvecRef ? 'required|string|max:100' : 'nullable|string|max:100',
            'note'          => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'montant.required'       => 'Le montant est obligatoire.',
            'montant.min'            => 'Le montant doit être supérieur à 0.',
            'mode_paiement.required' => 'Le mode de paiement est obligatoire.',
            'date_paiement.required' => 'La date de paiement est obligatoire.',
            'reference.required'     => 'La référence est obligatoire pour un chèque ou virement.',
        ];
    }
}
