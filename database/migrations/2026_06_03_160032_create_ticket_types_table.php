<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id('id_ticket_type');
            $table->foreignId('id_event')->constrained('events', 'id_event')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->decimal('price', 12, 2);
            $table->integer('quota');
            $table->integer('sold_count')->default(0);
            $table->integer('reserved_count')->default(0);
            $table->integer('version')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};