<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->id('id_organizer');
            $table->string('nama_organizer');
            $table->string('nama_penanggungjawab');
            $table->string('no_hp_organizer', 20);
            $table->string('email_organizer')->unique();
            $table->string('password');
            $table->text('deskripsi_organizer')->nullable();
            $table->string('logo_organizer')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizers');
    }
};