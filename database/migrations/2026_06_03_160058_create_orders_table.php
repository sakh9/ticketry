<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->foreignId('id_visitor')->constrained('visitors', 'id_visitor')->onDelete('cascade');
            $table->foreignId('id_event')->constrained('events', 'id_event')->onDelete('cascade');
            $table->decimal('total_price', 12, 2);
            $table->decimal('admin_fee', 8, 2)->default(0);
            $table->string('payment_method')->nullable();
            $table->string('virtual_account')->nullable();
            $table->timestamp('va_expired_at')->nullable();
            $table->enum('status', ['pending', 'paid', 'expired', 'cancelled'])->default('pending');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('reservation_expires_at')->nullable();
            $table->timestamp('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};