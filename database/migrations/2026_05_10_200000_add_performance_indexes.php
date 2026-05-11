<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mouvements_stock', function (Blueprint $table) {
            $table->index('date_mouvement');
            $table->index('type_mouvement');
        });

        Schema::table('ventes', function (Blueprint $table) {
            $table->index('date_vente');
            $table->index('statut_paiement');
        });

        Schema::table('paiements', function (Blueprint $table) {
            $table->index('date_paiement');
        });

        Schema::table('rappels', function (Blueprint $table) {
            $table->index('date_rappel_prevu');
            $table->index('statut');
        });

        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->index('date_heure');
        });

        Schema::table('produits', function (Blueprint $table) {
            $table->index('quantite_stock');
        });
    }

    public function down(): void
    {
        Schema::table('mouvements_stock', function (Blueprint $table) {
            $table->dropIndex(['date_mouvement']);
            $table->dropIndex(['type_mouvement']);
        });
        Schema::table('ventes', function (Blueprint $table) {
            $table->dropIndex(['date_vente']);
            $table->dropIndex(['statut_paiement']);
        });
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropIndex(['date_paiement']);
        });
        Schema::table('rappels', function (Blueprint $table) {
            $table->dropIndex(['date_rappel_prevu']);
            $table->dropIndex(['statut']);
        });
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->dropIndex(['date_heure']);
        });
        Schema::table('produits', function (Blueprint $table) {
            $table->dropIndex(['quantite_stock']);
        });
    }
};
