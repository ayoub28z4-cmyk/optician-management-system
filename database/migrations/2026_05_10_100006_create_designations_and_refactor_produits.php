<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Créer la table designations
        if (!Schema::hasTable('designations')) {
            Schema::create('designations', function (Blueprint $table) {
                $table->id();
                $table->string('nom', 255)->unique();
                $table->timestamps();
            });
        }

        // 2. Migrer les valeurs champ_reserve existantes → designations
        if (Schema::hasColumn('produits', 'champ_reserve')) {
            $champReserves = DB::table('produits')
                ->select('champ_reserve')
                ->whereNotNull('champ_reserve')
                ->distinct()
                ->pluck('champ_reserve');

            foreach ($champReserves as $nom) {
                $nom = trim($nom);
                if ($nom === '') continue;

                if (!DB::table('designations')->where('nom', $nom)->exists()) {
                    DB::table('designations')->insert([
                        'nom'        => $nom,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // 3. Ajouter designation_id (nullable d'abord pour la migration des données)
        if (!Schema::hasColumn('produits', 'designation_id')) {
            Schema::table('produits', function (Blueprint $table) {
                $table->unsignedBigInteger('designation_id')->nullable()->after('type_article_id');
                $table->foreign('designation_id')->references('id')->on('designations')->onDelete('restrict');
            });
        }

        // 4. Remplir designation_id depuis champ_reserve
        if (Schema::hasColumn('produits', 'champ_reserve')) {
            $designations = DB::table('designations')->pluck('id', 'nom');

            foreach ($designations as $nom => $id) {
                DB::table('produits')
                    ->where('champ_reserve', $nom)
                    ->update(['designation_id' => $id]);
            }
        }

        // 5. Rendre designation_id NOT NULL
        DB::statement('ALTER TABLE produits MODIFY designation_id BIGINT UNSIGNED NOT NULL');

        // 6. Ajouter la nouvelle contrainte unique AVANT de supprimer l'ancienne.
        // MySQL utilise produits_unique_triplet comme index support du FK societe_id ;
        // on doit lui fournir un remplaçant avant de pouvoir le supprimer.
        $indexes = collect(DB::select("SHOW INDEX FROM produits WHERE Key_name = 'produits_unique_article'"));
        if ($indexes->isEmpty()) {
            Schema::table('produits', function (Blueprint $table) {
                $table->unique(['societe_id', 'type_article_id', 'designation_id'], 'produits_unique_article');
            });
        }

        // 7. Supprimer l'ancienne contrainte unique (maintenant remplacée)
        foreach (['produits_unique_triplet', 'produits_societe_id_type_article_id_champ_reserve_unique'] as $idxName) {
            try {
                DB::statement("ALTER TABLE produits DROP INDEX `{$idxName}`");
            } catch (\Throwable) {}
        }

        // 8. Supprimer champ_reserve
        if (Schema::hasColumn('produits', 'champ_reserve')) {
            Schema::table('produits', function (Blueprint $table) {
                $table->dropColumn('champ_reserve');
            });
        }
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            try { $table->dropUnique('produits_unique_article'); } catch (\Throwable) {}
            try { $table->dropForeign(['designation_id']); } catch (\Throwable) {}
            $table->dropColumn('designation_id');
            $table->string('champ_reserve', 255)->nullable();
        });

        Schema::dropIfExists('designations');
    }
};
