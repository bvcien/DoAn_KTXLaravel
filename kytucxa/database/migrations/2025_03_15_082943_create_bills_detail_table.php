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
        Schema::create('bills_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idBill');
            $table->unsignedBigInteger('idPay'); // Tham chiếu đến phương thức thanh toán
            $table->decimal('price', 15, 2);
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('idBill')->references('id')->on('bills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills_detail');
    }
};
