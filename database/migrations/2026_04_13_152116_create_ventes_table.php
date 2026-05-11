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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ordonnance_id')->nullable()->constrained('ordonnances')->onDelete('set null');

            $table->string('numero_facture')->unique();
            $table->date('date_vente');
            $table->decimal('remise', 5, 2)->default(0);
            $table->decimal('total_ht', 10, 2)->default(0);
            $table->decimal('total_ttc', 10, 2)->default(0);
            $table->enum('statut_paiement', ['non_paye', 'partiel', 'solde'])->default('non_paye');
            $table->text('remarque')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
