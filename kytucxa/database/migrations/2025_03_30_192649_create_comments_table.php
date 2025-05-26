<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUser')->constrained('users')->onDelete('cascade'); // Người bình luận
            $table->foreignId('idNews')->constrained('news')->onDelete('cascade'); // Bài viết
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // Bình luận cha
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('comments');
    }
};
