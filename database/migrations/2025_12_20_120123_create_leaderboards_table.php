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
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('week'); // Numéro de semaine (1-52)
            $table->integer('year'); // 2025
            $table->integer('points')->default(0); // Points gagnés CETTE SEMAINE là
            $table->timestamps();

            // Index unique pour qu'un user n'ait qu'une ligne par semaine
            $table->unique(['user_id', 'week', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaderboards');
    }
};
