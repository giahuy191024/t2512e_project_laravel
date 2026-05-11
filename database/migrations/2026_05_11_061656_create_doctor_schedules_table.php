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
    public function run()
    {
        $schedule = \App\Models\DoctorSchedule::create([
            'doctor_id' => 1,
            'work_date' => now()->addDays(1)->toDateString(), // Ngày mai
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
        ]);

        // Tạo 3 ca khám mẫu
        \App\Models\TimeSlot::create(['schedule_id' => $schedule->id, 'start_time' => '08:00:00', 'end_time' => '09:00:00', 'max_patient' => 2]);
        \App\Models\TimeSlot::create(['schedule_id' => $schedule->id, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'max_patient' => 2]);
        \App\Models\TimeSlot::create(['schedule_id' => $schedule->id, 'start_time' => '10:00:00', 'end_time' => '11:00:00', 'max_patient' => 2]);
    }
};
