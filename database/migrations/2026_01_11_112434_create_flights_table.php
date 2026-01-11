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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->nullable();
            $table->string('offer_id')->nullable();
            $table->string('airline_name')->nullable();
            $table->string('airline_code')->nullable();
            $table->string('origin_code')->nullable();
            $table->string('destination_code')->nullable();
            $table->datetime('departure_time')->nullable();
            $table->datetime('arrival_time')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->integer('stops')->default(0);
            $table->string('duration')->nullable();
            $table->string('cabin_class')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
