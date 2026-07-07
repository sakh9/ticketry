<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('place');
            $table->text('address');
            $table->string('city');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed Indonesian locations
        DB::table('locations')->insert([
            ['place' => 'Jakarta Convention Center', 'address' => 'Jl. Gatot Subroto No.1', 'city' => 'Jakarta', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'ICE BSD City', 'address' => 'Jl. BSD Grand Boulevard', 'city' => 'Tangerang', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'Jatim Expo', 'address' => 'Jl. Ahmad Yani No.57', 'city' => 'Surabaya', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'The Westin Resort', 'address' => 'Jl. Raya Nusa Dua', 'city' => 'Bali', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'Gedung Sate', 'address' => 'Jl. Diponegoro No.22', 'city' => 'Bandung', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'Santika Premiere Hotel', 'address' => 'Jl. Pandanaran No.11', 'city' => 'Semarang', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'Jogja Expo Center', 'address' => 'Jl. Janti, Banguntapan', 'city' => 'Yogyakarta', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'Medan International Convention Center', 'address' => 'Jl. Gagak Hitam No.1', 'city' => 'Medan', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'Ballroom The Ritz-Carlton', 'address' => 'Jl. DR. Ide Anak Agung Gde Agung', 'city' => 'Jakarta', 'created_at' => now(), 'updated_at' => now()],
            ['place' => 'Trans Studio Convention Hall', 'address' => 'Jl. Gatot Subroto No.289', 'city' => 'Bandung', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};