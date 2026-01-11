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
        Schema::create('cruises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('departure_port');
            $table->string('destination_port');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('total_cabins')->default(100);
            $table->integer('available_cabins')->default(100);
            $table->string('cruise_line')->nullable();
            $table->string('ship_name')->nullable();
            $table->date('departure_date');
            $table->date('return_date');
            $table->integer('duration_days')->nullable();
            $table->string('cabin_type')->nullable(); // Suite, Deluxe, Standard, etc.
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
        Schema::dropIfExists('cruises');
    }
};
