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
        Schema::table('tours', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('tours', 'title')) {
                $table->string('title')->nullable()->after('name');
            }
            if (!Schema::hasColumn('tours', 'destination')) {
                $table->string('destination')->nullable()->after('location');
            }
            if (!Schema::hasColumn('tours', 'city')) {
                $table->string('city')->nullable()->after('destination');
            }
            if (!Schema::hasColumn('tours', 'duration_minutes')) {
                $table->integer('duration_minutes')->nullable()->after('duration');
            }
            if (!Schema::hasColumn('tours', 'category')) {
                $table->string('category')->nullable()->after('type');
            }
            if (!Schema::hasColumn('tours', 'rating')) {
                $table->decimal('rating', 3, 2)->nullable()->after('category');
            }
            if (!Schema::hasColumn('tours', 'reviews_count')) {
                $table->integer('reviews_count')->default(0)->after('rating');
            }
            if (!Schema::hasColumn('tours', 'max_group_size')) {
                $table->integer('max_group_size')->nullable()->after('reviews_count');
            }
            if (!Schema::hasColumn('tours', 'image_url')) {
                $table->string('image_url')->nullable()->after('image');
            }
            if (!Schema::hasColumn('tours', 'currency')) {
                $table->string('currency')->default('USD')->after('price');
            }
            if (!Schema::hasColumn('tours', 'popularity_score')) {
                $table->integer('popularity_score')->default(0)->after('is_active');
            }
            if (!Schema::hasColumn('tours', 'start_date')) {
                $table->date('start_date')->nullable()->after('popularity_score');
            }
            if (!Schema::hasColumn('tours', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('tours', 'languages')) {
                $table->json('languages')->nullable()->after('max_group_size');
            }
            if (!Schema::hasColumn('tours', 'highlights')) {
                $table->json('highlights')->nullable()->after('languages');
            }
            if (!Schema::hasColumn('tours', 'inclusions')) {
                $table->json('inclusions')->nullable()->after('highlights');
            }
            if (!Schema::hasColumn('tours', 'available_dates')) {
                $table->json('available_dates')->nullable()->after('inclusions');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            // Just drop the whole table and recreate original
            // OR drop specific columns if they exist
            $columns = ['title', 'destination', 'city', 'duration_minutes', 'category', 'rating', 'reviews_count', 'max_group_size', 'image_url', 'currency', 'popularity_score', 'start_date', 'end_date', 'languages', 'highlights', 'inclusions', 'available_dates'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('tours', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
