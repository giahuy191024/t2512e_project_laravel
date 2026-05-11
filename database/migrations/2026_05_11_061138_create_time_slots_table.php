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
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            // Trỏ tới bảng lịch làm việc ở trên
            $table->foreignId('schedule_id')->constrained('doctor_schedules')->onDelete('cascade');

            $table->time('start_time'); // Ví dụ: 08:00
            $table->time('end_time');   // Ví dụ: 08:30

            $table->integer('max_patient')->default(2); // Tối đa 2 người/ca
            $table->integer('current_patient')->default(0); // Số người đã đặt

            // 0 = full, 1 = available, 2 = locked, 3 = cancelled
            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
