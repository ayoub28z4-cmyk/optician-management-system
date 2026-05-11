<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'classement_registre' => 'nullable|string|max:50',
            'nom'                 => 'required|string|max:100',
            'prenom'              => 'required|string|max:100',
            'cin'                 => 'required|string|unique:clients,cin|max:20',
            'genre'               => 'nullable|in:homme,femme',
            'date_naissance'      => 'nullable|date',
            'telephone'           => 'required|string|max:20',
            'email'               => 'nullable|email|max:100',
            'adresse'             => 'nullable|string|max:255',
            'type'                => 'required|in:nouveau,ancien',
            'observations'        => 'nullable|string',
            'mutuelle_type'  => 'required|in:cnops,cnss,autre,aucune',
            'mutuelle_autre' => 'nullable|string|max:100|required_if:mutuelle_type,autre',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'       => 'Le nom est obligatoire.',
            'prenom.required'    => 'Le prénom est obligatoire.',
            'cin.required'       => 'Le CIN est obligatoire.',
            'cin.unique'         => 'Ce CIN existe déjà dans le système.',
            'telephone.required' => 'Le téléphone est obligatoire.',
            'type.required'      => 'Le type de client est obligatoire.',
        ];
    }
}
