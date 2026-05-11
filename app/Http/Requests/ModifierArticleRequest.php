<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModifierArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $produit = $this->route('article');

        return [
            'societe_id'        => 'required|exists:societes,id',
            'type_article_id'   => 'required|exists:types_articles,id',
            'designation_id'    => [
                'required',
                'exists:designations,id',
                Rule::unique('produits')->where(function ($query) {
                    return $query
                        ->where('societe_id', $this->societe_id)
                        ->where('type_article_id', $this->type_article_id);
                })->ignore($produit),
            ],
            'prix_achat_actuel' => 'required|numeric|min:0',
            'seuil_alerte'      => 'required|integer|min:0|max:9999',
        ];
    }

    public function attributes(): array
    {
        return [
            'societe_id'        => 'société',
            'type_article_id'   => 'type d\'article',
            'designation_id'    => 'désignation',
            'prix_achat_actuel' => 'prix d\'achat',
            'seuil_alerte'      => 'seuil d\'alerte',
        ];
    }
}
