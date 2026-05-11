<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeArticle extends Model
{
    use HasFactory;

    protected $table = 'types_articles';

    protected $fillable = ['nom'];

    public function produits(): HasMany
    {
        return $this->hasMany(Produit::class);
    }
}
