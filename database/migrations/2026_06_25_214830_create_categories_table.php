<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Seed default categories
        DB::table('categories')->insert([
            ['name' => 'Music', 'slug' => 'music', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sports', 'slug' => 'sports', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Technology', 'slug' => 'technology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business', 'slug' => 'business', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Art & Culture', 'slug' => 'art-culture', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Education', 'slug' => 'education', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Food & Beverage', 'slug' => 'food-beverage', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Health & Wellness', 'slug' => 'health-wellness', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Charity', 'slug' => 'charity', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Other', 'slug' => 'other', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};