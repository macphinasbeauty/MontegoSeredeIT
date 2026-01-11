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
        Schema::create('user_social_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('platform'); // 'facebook', 'twitter', 'instagram', 'youtube'
            $table->string('profile_url')->nullable(); // Profile URL or username
            $table->string('profile_id')->nullable(); // Social media profile ID
            $table->boolean('verified')->default(false); // Verification status
            $table->json('metadata')->nullable(); // Additional platform-specific data
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'platform']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_social_profiles');
    }
};
