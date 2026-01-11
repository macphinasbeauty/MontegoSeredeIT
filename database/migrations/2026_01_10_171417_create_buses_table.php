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
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route_from');
            $table->string('route_to');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('total_seats')->default(50);
            $table->integer('available_seats')->default(50);
            $table->string('bus_number')->nullable();
            $table->string('operator')->nullable();
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->decimal('duration_hours', 4, 2)->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
