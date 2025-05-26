<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idSender');
            $table->unsignedBigInteger('idReceiver');
            $table->string('content', 999);
            $table->timestamps();

            // Foreign keys
            $table->foreign('idSender')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idReceiver')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
