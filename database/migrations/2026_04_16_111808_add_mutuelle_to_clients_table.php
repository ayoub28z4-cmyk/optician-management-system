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
    Schema::table('clients', function (Blueprint $table) {
        $table->enum('mutuelle_type', ['cnops', 'cnss', 'autre', 'aucune'])
              ->default('aucune')
              ->after('type');
        $table->string('mutuelle_autre')->nullable()->after('mutuelle_type');
    });
}

public function down(): void
{
    Schema::table('clients', function (Blueprint $table) {
        $table->dropColumn(['mutuelle_type', 'mutuelle_autre']);
    });
}
};
