<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizers', function (Blueprint $table) {
            $table->string('bank_code', 3)->nullable()->after('sosial_media');
            $table->string('bank_name')->nullable()->after('bank_code');
            $table->string('bank_account_number', 20)->nullable()->after('bank_name');
            $table->string('bank_account_name')->nullable()->after('bank_account_number');
        });
    }

    public function down(): void
    {
        Schema::table('organizers', function (Blueprint $table) {
            $table->dropColumn(['bank_code', 'bank_name', 'bank_account_number', 'bank_account_name']);
        });
    }
};