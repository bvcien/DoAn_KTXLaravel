<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUser')->constrained('users')->onDelete('cascade');
            $table->decimal('totalPrice', 10, 2);
            $table->text('content')->nullable();
            $table->tinyInteger('status'); // 0: Chờ xử lý, 1: Đã thanh toán, 2: Hủy
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
