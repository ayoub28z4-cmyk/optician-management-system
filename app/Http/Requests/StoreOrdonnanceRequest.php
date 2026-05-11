<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdonnanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id'        => 'required|exists:clients,id',
            'date_ordonnance'  => 'required|date',
            'medecin'          => 'nullable|string|max:150',
            'od_sphere'        => 'nullable|string|max:10',
            'od_cylindre'      => 'nullable|string|max:10',
            'od_axe'           => 'nullable|string|max:10',
            'og_sphere'        => 'nullable|string|max:10',
            'og_cylindre'      => 'nullable|string|max:10',
            'og_axe'           => 'nullable|string|max:10',
            'addition'         => 'nullable|string|max:10',
            'ecart_pupillaire' => 'nullable|string|max:10',
            'remarques'        => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required'       => 'Le client est obligatoire.',
            'client_id.exists'         => 'Ce client n\'existe pas.',
            'date_ordonnance.required' => 'La date de l\'ordonnance est obligatoire.',
        ];
    }
}
