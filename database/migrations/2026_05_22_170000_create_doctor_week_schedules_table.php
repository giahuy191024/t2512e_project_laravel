<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('doctor_week_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->date('week_start'); // Ngày đầu tuần (thứ 2)
            $table->tinyInteger('day_of_week'); // 1=Thứ 2 ... 7=Chủ nhật
            $table->string('slot_code', 20); // mã ca: morning, afternoon, evening hoặc slot1, slot2...
            $table->timestamps();

            $table->unique(['doctor_id','week_start','day_of_week','slot_code'], 'uniq_doctor_week_slot');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_week_schedules');
    }
};
