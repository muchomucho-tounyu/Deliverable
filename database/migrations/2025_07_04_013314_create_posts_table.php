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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');     // 投稿者
            $table->foreignId('work_id')->nullable()->constrained()->onDelete('cascade'); // 紐づく作品
            $table->foreignId('song_id')->nullable()->constrained()->onDelete('cascade'); // 紐づく楽曲
            $table->foreignId('place_id')->nullable()->constrained()->onDelete('cascade'); // 場所

            $table->string('image_path')->nullable();   // 画像
            $table->string('place_detail')->nullable(); // 詳細
            $table->string('title');                 // 投稿タイトル
            $table->text('body')->nullable();     // 投稿本文・感想
            $table->decimal('latitude', 10, 7)->nullable();  // 地図用（任意）
            $table->decimal('longitude', 10, 7)->nullable(); // 地図用（任意）

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
