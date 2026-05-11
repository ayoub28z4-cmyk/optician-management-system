<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetirerStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantite' => 'required|integer|min:1',
            'motif'    => 'required|in:vente,casse,retour',
        ];
    }

    public function attributes(): array
    {
        return [
            'quantite' => 'quantité',
            'motif'    => 'motif de retrait',
        ];
    }
}
