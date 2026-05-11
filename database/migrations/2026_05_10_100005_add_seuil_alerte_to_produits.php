<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            if (!Schema::hasColumn('produits', 'seuil_alerte')) {
                $table->unsignedSmallInteger('seuil_alerte')->default(5)->after('quantite_stock');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            if (Schema::hasColumn('produits', 'seuil_alerte')) {
                $table->dropColumn('seuil_alerte');
            }
        });
    }
};
