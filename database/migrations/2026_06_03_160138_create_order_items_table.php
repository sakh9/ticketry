<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('id_order_item');
            $table->foreignId('id_order')->constrained('orders', 'id_order')->onDelete('cascade');
            $table->foreignId('id_ticket_type')->constrained('ticket_types', 'id_ticket_type')->onDelete('cascade');
            $table->string('visitor_name');
            $table->string('visitor_email');
            $table->string('visitor_phone');
            $table->string('ktp_path')->nullable();
            $table->string('ticket_code')->unique();
            $table->text('qr_code_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};