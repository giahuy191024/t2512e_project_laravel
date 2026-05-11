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
        // Đổi tên bảng thành 'bookings' cho đúng với DBML
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại trỏ đến bảng time_slots (ca khám)
            $table->foreignId('slot_id')->constrained('time_slots')->onDelete('cascade');

            // Khóa ngoại trỏ đến bảng patients (hồ sơ bệnh nhân)
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');

            // 0 = pending, 1 = confirmed, 2 = completed, 3 = cancelled, 4 = reject, 5 = no_show
            $table->tinyInteger('status')->default(0);

            // Lý do hủy khám (nếu có)
            $table->text('cancel_reason')->nullable();

            // Người tạo (ai thao tác tạo booking này, trỏ về bảng users)
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
