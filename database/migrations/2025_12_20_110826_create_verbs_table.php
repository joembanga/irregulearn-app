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
            $table->string('slug', 255)->unique();
            $table->string('infinitive')->unique();
            $table->string('past_simple');
            $table->string('past_participle');
            $table->enum('level', ['beginner', 'intermediate', 'expert'])->default('beginner');
            $table->text('description')->nullable();
            $table->string('phonetic')->nullable();
            $table->string('source_url')->nullable();
            $table->string('details_origin')->nullable();
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
