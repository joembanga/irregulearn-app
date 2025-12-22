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
            $table->string('username')->unique(); // Pour les URLs (irregulearn.com/u/junior)
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // --- GAMIFICATION & PROGRESSION ---
            $table->integer('xp_total')->default(0);      // Score global (Classement)
            $table->integer('xp_balance')->default(0);    // Monnaie virtuelle (Achats)
            $table->integer('current_streak')->default(0); // Série en cours
            $table->date('last_activity_date')->nullable(); // Pour calculer le streak
            $table->integer('lives')->default(5);         // Vies (Max 5)
            $table->integer('daily_target')->default(5);  // Objectif de verbes/jour

            // --- PROFIL & RÔLE ---
            $table->string('avatar')->nullable();         // URL de la photo
            $table->string('role')->default('user');      // 'admin' ou 'user'
            $table->boolean('is_premium')->default(false);

            // --- PARRAINAGE ---
            $table->foreignId('referred_by')->nullable()->constrained('users')->nullOnDelete();
            
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
