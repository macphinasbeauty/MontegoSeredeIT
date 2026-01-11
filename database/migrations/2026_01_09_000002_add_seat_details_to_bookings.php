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
        Schema::table('bookings', function (Blueprint $table) {
            // Add seat details as JSON if not already present
            if (!Schema::hasColumn('bookings', 'seat_details')) {
                $table->json('seat_details')->nullable()->comment('Selected seat IDs with passenger assignments');
            }
            
            // Add PNR (Booking Reference) if not already present
            if (!Schema::hasColumn('bookings', 'pnr')) {
                $table->string('pnr')->nullable()->unique()->comment('Booking Reference Number');
            }
            
            // Add order ID from API
            if (!Schema::hasColumn('bookings', 'order_id')) {
                $table->string('order_id')->nullable()->comment('Order ID from flight API provider');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['seat_details', 'pnr', 'order_id']);
        });
    }
};
