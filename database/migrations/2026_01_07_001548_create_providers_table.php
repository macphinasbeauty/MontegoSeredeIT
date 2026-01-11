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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Duffel, Amadeus
            $table->string('type'); // flights, hotels, etc.
            $table->text('api_key')->nullable();
            $table->text('api_secret')->nullable();
            $table->string('endpoint')->nullable();
            $table->json('config')->nullable(); // additional config
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
