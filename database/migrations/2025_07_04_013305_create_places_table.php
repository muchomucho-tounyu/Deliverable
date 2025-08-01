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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // 場所の名前
            $table->string('address')->nullable(); // 住所
            $table->decimal('latitude', 10, 7)->nullable();  // 緯度（Google Map用）
            $table->decimal('longitude', 10, 7)->nullable(); // 経度（Google Map用）

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
