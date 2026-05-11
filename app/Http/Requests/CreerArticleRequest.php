<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreerArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isNew = $this->designation_id === 'new';

        return [
            'date'                 => 'required|date',
            'societe_id'           => 'required|exists:societes,id',
            'type_article_id'      => 'required|exists:types_articles,id',
            'designation_id'       => 'required|string',
            'nouvelle_designation' => $isNew ? 'required|string|max:255' : 'nullable|string|max:255',
            'quantite'             => 'required|integer|min:1',
            'prix_achat'           => 'required|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'societe_id'           => 'société',
            'type_article_id'      => 'type d\'article',
            'designation_id'       => 'désignation',
            'nouvelle_designation' => 'nouvelle désignation',
            'quantite'             => 'quantité',
            'prix_achat'           => 'prix d\'achat',
        ];
    }
}
