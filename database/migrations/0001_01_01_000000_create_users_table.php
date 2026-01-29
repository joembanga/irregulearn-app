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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255)->unique();
            $table->string('firstname', 255);
            $table->string('lastname', 255);
            $table->string('email', 255)->unique();
            $table->string('google_id')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->bigInteger('xp_weekly')->default(0)->unsigned();
            $table->bigInteger('xp_total')->default(0)->unsigned();
            $table->bigInteger('xp_balance')->default(0)->unsigned();
            $table->integer('current_streak')->default(0)->unsigned();
            $table->tinyInteger('streak_freezes')->default(0)->unsigned();
            $table->unsignedInteger('best_streak')->default(0);
            $table->longText('search_history')->nullable();

            // A user keep his streak when he learn day's verbs or do at least one exercise
            $table->string('timezone')->default('UTC'); // eg: "Europe/Paris"
            $table->datetime('last_activity_local_date')->nullable();
            $table->tinyInteger('daily_target')->default(5)->max(10);

            // --- PROFILE & ROLE ---
            $table->text('avatar_code')->nullable();
            $table->text('avatar_url')->nullable();
            $table->json('unlocked_items')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->boolean('is_premium')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
