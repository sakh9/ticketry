<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizers', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false)->after('role_id');
            $table->timestamp('banned_at')->nullable()->after('is_banned');
            $table->text('ban_reason')->nullable()->after('banned_at');
        });

        Schema::table('visitors', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false)->after('role_id');
            $table->timestamp('banned_at')->nullable()->after('is_banned');
            $table->text('ban_reason')->nullable()->after('banned_at');
        });
    }

    public function down(): void
    {
        Schema::table('organizers', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'banned_at', 'ban_reason']);
        });
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'banned_at', 'ban_reason']);
        });
    }
};