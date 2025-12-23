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
        Schema::create('verb_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verb_id')->constrained('verbs')->cascadeOnDelete();
            $table->string('lang')->default('fr');
            $table->string('translation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verb_translation');
    }
};
