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
        Schema::create('user_linked_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('provider'); // 'google', 'google_calendar', 'google_maps'
            $table->string('provider_id')->nullable(); // OAuth provider ID
            $table->string('name')->nullable(); // Display name
            $table->string('email')->nullable(); // Account email
            $table->text('access_token')->nullable(); // OAuth access token
            $table->text('refresh_token')->nullable(); // OAuth refresh token
            $table->timestamp('token_expires_at')->nullable(); // Token expiry
            $table->boolean('connected')->default(false); // Connection status
            $table->json('settings')->nullable(); // Provider-specific settings
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'provider']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_linked_accounts');
    }
};
