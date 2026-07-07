<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'online_platform')) {
                $table->dropColumn('online_platform');
            }
            if (Schema::hasColumn('events', 'online_url')) {
                $table->dropColumn('online_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('online_platform')->nullable();
            $table->string('online_url')->nullable();
        });
    }
};