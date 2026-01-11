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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('make'); // Toyota
            $table->string('model'); // Camry
            $table->integer('year');
            $table->integer('seats');
            $table->string('transmission'); // automatic, manual
            $table->string('fuel_type'); // petrol, diesel, electric
            $table->string('location');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
            $table->json('features')->nullable(); // AC, GPS, etc.
            $table->json('images')->nullable();
            $table->boolean('is_manual')->default(true);
            $table->string('api_id')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
