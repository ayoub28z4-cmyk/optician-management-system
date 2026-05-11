<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Désactivation des FK checks + purge des anciennes données incompatibles
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('stock_mouvements')->truncate();
        DB::table('vente_lignes')->update(['produit_id' => null]);
        DB::table('produits')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Schema::table('produits', function (Blueprint $table) {
            // Suppression des colonnes de l'ancien système (si elles existent encore)
            $oldColumns = ['reference', 'designation', 'categorie', 'marque', 'modele',
                           'prix_achat', 'prix_vente', 'seuil_alerte', 'is_active', 'description'];
            $toDrop = array_filter($oldColumns, fn($col) => Schema::hasColumn('produits', $col));
            if (!empty($toDrop)) {
                $table->dropColumn(array_values($toDrop));
            }
        });

        Schema::table('produits', function (Blueprint $table) {
            // Supprime la clé étrangère societe_id si elle existe déjà sans contrainte propre
            if (Schema::hasColumn('produits', 'societe_id')) {
                // Recrée la contrainte proprement en modifiant le type
                $table->foreignId('societe_id')->change();
            } else {
                $table->foreignId('societe_id')->after('id');
            }

            if (!Schema::hasColumn('produits', 'type_article_id')) {
                $table->foreignId('type_article_id')->after('societe_id');
            }

            if (!Schema::hasColumn('produits', 'champ_reserve')) {
                $table->string('champ_reserve')->after('type_article_id')
                      ->comment('Désignation libre : modèle, référence, couleur…');
            }

            if (!Schema::hasColumn('produits', 'prix_achat_actuel')) {
                $table->decimal('prix_achat_actuel', 10, 2)->after('champ_reserve')->default(0);
            }

            $table->unsignedInteger('quantite_stock')->default(0)->change();
        });

        // Ajout des FK et contrainte unique après toutes les colonnes
        Schema::table('produits', function (Blueprint $table) {
            // Nettoie les éventuelles FK orphelines avant re-création
            $foreignKeys = collect(Schema::getForeignKeys('produits'))->pluck('name');
            if ($foreignKeys->contains('produits_societe_id_foreign')) {
                $table->dropForeign(['societe_id']);
            }
            if ($foreignKeys->contains('produits_type_article_id_foreign')) {
                $table->dropForeign(['type_article_id']);
            }

            $table->foreign('societe_id')->references('id')->on('societes')->restrictOnDelete();
            $table->foreign('type_article_id')->references('id')->on('types_articles')->restrictOnDelete();

            $indexes = collect(Schema::getIndexes('produits'))->pluck('name');
            if (!$indexes->contains('produits_unique_triplet')) {
                $table->unique(['societe_id', 'type_article_id', 'champ_reserve'], 'produits_unique_triplet');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $foreignKeys = collect(Schema::getForeignKeys('produits'))->pluck('name');
            if ($foreignKeys->contains('produits_societe_id_foreign')) {
                $table->dropForeign(['societe_id']);
            }
            if ($foreignKeys->contains('produits_type_article_id_foreign')) {
                $table->dropForeign(['type_article_id']);
            }

            $indexes = collect(Schema::getIndexes('produits'))->pluck('name');
            if ($indexes->contains('produits_unique_triplet')) {
                $table->dropUnique('produits_unique_triplet');
            }

            $table->dropColumn(array_filter(
                ['societe_id', 'type_article_id', 'champ_reserve', 'prix_achat_actuel'],
                fn($col) => Schema::hasColumn('produits', $col)
            ));

            $table->string('reference')->unique();
            $table->string('designation');
            $table->enum('categorie', ['monture', 'verre', 'accessoire', 'prestation']);
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->decimal('prix_achat', 10, 2)->default(0);
            $table->decimal('prix_vente', 10, 2)->default(0);
            $table->integer('seuil_alerte')->default(2);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
        });
    }
};
