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
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->text('commentaire')->nullable();
            $table->integer('note')->nullable();;
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_contenu')->constrained('contenus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('commentaires');
        Schema::enableForeignKeyConstraints();
    }
};
