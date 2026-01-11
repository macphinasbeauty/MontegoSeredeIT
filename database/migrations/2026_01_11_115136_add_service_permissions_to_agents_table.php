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
        Schema::table('agents', function (Blueprint $table) {
            $table->boolean('can_manage_hotels')->default(false)->after('user_id');
            $table->boolean('can_manage_cars')->default(false)->after('can_manage_hotels');
            $table->boolean('can_manage_tours')->default(false)->after('can_manage_cars');
            $table->boolean('can_manage_cruises')->default(false)->after('can_manage_tours');
            $table->boolean('can_manage_buses')->default(false)->after('can_manage_cruises');
            $table->boolean('can_manage_flights')->default(false)->after('can_manage_buses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'can_manage_hotels',
                'can_manage_cars',
                'can_manage_tours',
                'can_manage_cruises',
                'can_manage_buses',
                'can_manage_flights'
            ]);
        });
    }
};
