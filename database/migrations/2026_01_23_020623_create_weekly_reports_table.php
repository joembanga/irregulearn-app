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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->integer('verbs_mastered_count')->default(0);
            $table->integer('xp_earned')->default(0);
            $table->integer('streak_at_start')->default(0);
            $table->integer('streak_at_end')->default(0);
            $table->integer('leaderboard_rank_start')->nullable();
            $table->integer('leaderboard_rank_end')->nullable();
            $table->boolean('image_generated')->default(false);
            $table->integer('shared_count')->default(0);
            $table->timestamps();
            
            // Ensure one report per user per week
            $table->unique(['user_id', 'week_start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
