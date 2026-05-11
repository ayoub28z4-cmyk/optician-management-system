<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vente_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vente_id')->constrained('ventes')->onDelete('cascade');
            $table->foreignId('produit_id')->nullable()->constrained('produits')->onDelete('set null');

            // On stocke les données au moment de la vente
            // pour que la facture reste exacte même si le prix change
            $table->string('designation');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('remise_ligne', 5, 2)->default(0);
            $table->decimal('sous_total', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vente_lignes');
    }
};
