<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->decimal('admin_fee', 10, 2)->default(25000)->after('ticket_access');
            $table->enum('fee_status', ['unpaid', 'paid'])->default('unpaid')->after('admin_fee');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['admin_fee', 'fee_status']);
        });
    }
};