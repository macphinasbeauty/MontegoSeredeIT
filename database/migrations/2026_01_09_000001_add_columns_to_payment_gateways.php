<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('payment_gateways')) {
            Schema::table('payment_gateways', function (Blueprint $table) {
                if (!Schema::hasColumn('payment_gateways', 'enabled')) {
                    $table->boolean('enabled')->default(false)->after('name');
                }
                if (!Schema::hasColumn('payment_gateways', 'settings')) {
                    $table->json('settings')->nullable()->after('enabled');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('payment_gateways')) {
            Schema::table('payment_gateways', function (Blueprint $table) {
                if (Schema::hasColumn('payment_gateways', 'settings')) {
                    $table->dropColumn('settings');
                }
                if (Schema::hasColumn('payment_gateways', 'enabled')) {
                    $table->dropColumn('enabled');
                }
            });
        }
    }
};
