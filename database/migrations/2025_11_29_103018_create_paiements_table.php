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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('contenu_id')->constrained('contenus')->onDelete('cascade');

            $table->decimal('montant', 10, 2);

            // On gère vraiment l'enum dans le code
            $table->string('statut');

            $table->string('numero');
            $table->string('paiement_methode');
            $table->string('transaction_id')->nullable();

            $table->timestamps();
            $table->unique(['user_id', 'contenu_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
