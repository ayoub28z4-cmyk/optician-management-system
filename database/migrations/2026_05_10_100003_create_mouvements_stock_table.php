<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')
                  ->constrained('produits')
                  ->cascadeOnDelete();
            $table->enum('type_mouvement', ['achat', 'vente', 'casse', 'retour']);
            $table->unsignedInteger('quantite');
            $table->decimal('prix_unitaire', 10, 2)->nullable();
            $table->date('date_mouvement');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mouvements_stock');
    }
};
