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
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Informations ordonnance
            $table->date('date_ordonnance');
            $table->string('medecin')->nullable();

            // Oeil droit (OD)
            $table->decimal('od_sphere', 5, 2)->nullable();
            $table->decimal('od_cylindre', 5, 2)->nullable();
            $table->decimal('od_axe', 5, 2)->nullable();

            // Oeil gauche (OG)
            $table->decimal('og_sphere', 5, 2)->nullable();
            $table->decimal('og_cylindre', 5, 2)->nullable();
            $table->decimal('og_axe', 5, 2)->nullable();

            // Commun
            $table->decimal('addition', 5, 2)->nullable();
            $table->decimal('ecart_pupillaire', 5, 2)->nullable();

            $table->text('remarques')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordonnances');
    }
};
