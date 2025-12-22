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
        Schema::create('verbs', function (Blueprint $table) {
            $table->id();
            $table->string('infinitive')->unique(); // Arise
            $table->string('past_simple');         // Arose
            $table->string('past_participle');     // Arisen
            $table->string('translation');         // Survenir
            $table->string('level')->default('beginner'); // beginner, intermediate, expert
            $table->string('category')->nullable(); // Business, Survival...
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verbs');
    }
};
