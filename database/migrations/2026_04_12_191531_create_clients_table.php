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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // Classement registre — lien avec le registre papier
            $table->string('classement_registre')->nullable();

            // Identité
            $table->string('nom');
            $table->string('prenom');
            $table->string('cin')->unique();
            $table->enum('genre', ['homme', 'femme'])->nullable();
            $table->date('date_naissance')->nullable();

            // Contact
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->string('adresse')->nullable();

            // Statut
            $table->enum('type', ['nouveau', 'ancien'])->default('nouveau');
            $table->boolean('is_active')->default(true);
            $table->text('observations')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
