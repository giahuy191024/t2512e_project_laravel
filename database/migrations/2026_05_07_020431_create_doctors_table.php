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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại trỏ đến các bảng khác (Bắt buộc các bảng này phải có trước)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('specialization_id')->constrained('specializations')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');

            // Các cột thông tin
            $table->string('full_name');
            $table->text('qualifications')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->text('description')->nullable();

            // Laravel mặc định cần 2 cột này, nếu bảng của ông không cần thì xóa đi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
