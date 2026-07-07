<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('location_type')->default('venue')->after('location_id');
            $table->string('other_place')->nullable()->after('location_type');
            $table->text('other_address')->nullable()->after('other_place');
            $table->string('other_city')->nullable()->after('other_address');
            $table->string('online_platform')->nullable()->after('other_city');
            $table->string('online_url')->nullable()->after('online_platform');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['location_type', 'other_place', 'other_address', 'other_city', 'online_platform', 'online_url']);
        });
    }
};