<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('doctor_schedules')->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('max_patient')->default(2);
            $table->integer('current_patient')->default(0);
            $table->tinyInteger('status')->default(1)
                ->comment('0=full, 1=available, 2=locked, 3=cancelled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
