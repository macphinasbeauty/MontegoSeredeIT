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
        Schema::create('hotel_city_codes', function (Blueprint $table) {
            $table->id();
            $table->string('city_code', 10)->unique()->index(); // e.g., NYC, LAX, LON, PAR
            $table->string('airport_code', 10)->nullable()->index(); // e.g., JFK, LHR, CDG
            $table->string('city_name', 100); // e.g., New York, London, Paris
            $table->string('country', 100); // e.g., United States, United Kingdom, France
            $table->text('aliases')->nullable(); // Comma-separated aliases (New York, NYC, NEWYORK)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_city_codes');
    }
};
