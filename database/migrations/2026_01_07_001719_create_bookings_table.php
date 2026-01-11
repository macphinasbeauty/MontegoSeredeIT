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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('set null');
            $table->string('bookable_type'); // App\Models\Villa, App\Models\Car, etc.
            $table->unsignedBigInteger('bookable_id');
            $table->date('check_in')->nullable(); // for hotels, villas
            $table->date('check_out')->nullable();
            $table->date('departure_date')->nullable(); // for flights
            $table->date('return_date')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->decimal('total_price', 15, 2);
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
            $table->json('details')->nullable(); // additional booking details, like flight info
            $table->unsignedBigInteger('payment_gateway_id')->nullable();
            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
