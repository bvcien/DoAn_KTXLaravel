<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_like', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUser')->constrained('users')->onDelete('cascade');
            $table->foreignId('idNew')->constrained('news')->onDelete('cascade');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_likes');
    }
};
