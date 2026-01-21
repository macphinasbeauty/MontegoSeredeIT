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
        Schema::create('viator_destinations', function (Blueprint $table) {
            $table->integer('destinationId')->primary();
            $table->string('name');
            $table->string('type');
            $table->integer('parentDestinationId')->nullable();
            $table->string('timeZone')->nullable();
            $table->string('currencyCode', 3)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viator_destinations');
    }
};
