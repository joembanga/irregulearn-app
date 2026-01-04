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
        Schema::create('verb_sentences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verb_id')->constrained()->cascadeOnDelete();
            $table->text('sentence');
            $table->string('missing_word');
            $table->string('form')->nullable(); // past_simple, past_participle, infinitive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verb_sentences');
    }
};
