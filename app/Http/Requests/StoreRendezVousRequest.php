<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRendezVousRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'   => 'required|exists:clients,id',
            'date_heure'  => 'required|date',
            'motif'       => 'required|string|max:200',
            'commentaire' => 'nullable|string',
            'statut'      => 'nullable|in:planifie,confirme,annule,termine',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required'  => 'Le client est obligatoire.',
            'date_heure.required' => 'La date et heure sont obligatoires.',
            'motif.required'      => 'Le motif est obligatoire.',
        ];
    }
}
