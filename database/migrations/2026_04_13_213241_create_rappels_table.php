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
        Schema::create('rappels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('ordonnance_id')->constrained('ordonnances')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->date('date_reference');      // date de l'ordonnance
            $table->date('date_eligibilite');    // date_reference + 2 ans
            $table->date('date_rappel_prevu');   // date_eligibilite - délai configurable

            $table->enum('statut', ['a_contacter', 'contacte', 'relance', 'traite'])->default('a_contacter');
            $table->text('note_contact')->nullable();
            $table->foreignId('traite_par')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('traite_at')->nullable();

            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rappels');
    }
};
