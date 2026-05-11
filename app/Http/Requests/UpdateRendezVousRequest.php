<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRendezVousRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_heure'  => 'required|date',
            'motif'       => 'required|string|max:200',
            'commentaire' => 'nullable|string',
            'statut'      => 'required|in:planifie,confirme,annule,termine',
        ];
    }
}
