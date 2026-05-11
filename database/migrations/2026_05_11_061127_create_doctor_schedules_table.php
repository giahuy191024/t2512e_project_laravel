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
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            // Trỏ tới bảng doctors
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->date('work_date'); // Ngày làm việc
            $table->time('start_time'); // Giờ bắt đầu ca lớn (ví dụ 08:00)
            $table->time('end_time');   // Giờ kết thúc ca lớn (ví dụ 17:00)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
