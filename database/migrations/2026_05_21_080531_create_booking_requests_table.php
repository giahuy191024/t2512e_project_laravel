<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Bảng lưu yêu cầu đặt lịch của KHÁCH VÃNG LAI (chưa đăng nhập).
     * Sau khi admin liên hệ và xếp slot xong → mới tạo bản ghi thật
     * trong patients + bookings, đồng thời cập nhật converted_booking_id ở đây.
     */
    public function up(): void
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();

            // === Thông tin khách cung cấp ===
            $table->string('full_name', 150);
            $table->string('phone_number', 20);
            $table->string('email_contact')->nullable();

            // === Mong muốn của khách ===
            // Để dạng string (không FK) — feature này KHÔNG phụ thuộc vào
            // việc bảng specializations / doctors đã hoàn thiện hay chưa.
            // Khi admin convert sang booking thật → mới select đúng ID.
            $table->string('specialty', 100)->nullable()->comment('Chuyên khoa quan tâm');
            $table->string('preferred_doctor', 150)->nullable()->comment('Bác sĩ cụ thể muốn gặp');
            $table->date('preferred_date')->nullable();
            $table->string('preferred_time_range', 30)->nullable()->comment('VD: 08:00-10:00, Sáng, Linh hoạt...');
            $table->text('note')->nullable();

            // === Trạng thái xử lý ===
            // 0 = pending (chờ xử lý)
            // 1 = contacted (đã liên hệ khách)
            // 2 = converted (đã chuyển thành booking thật)
            // 3 = cancelled (huỷ)
            $table->tinyInteger('status')->default(0);
            $table->text('admin_note')->nullable()->comment('Ghi chú nội bộ của admin');

            // === Liên kết ngược ===
            // Admin nào tiếp nhận
            $table->foreignId('handled_by')->nullable()
                ->constrained('users')->onDelete('set null');

            // Booking thật được tạo ra từ yêu cầu này (nếu đã convert)
            $table->foreignId('converted_booking_id')->nullable()
                ->constrained('bookings')->onDelete('set null');

            // === Anti-spam ===
            $table->string('ip_address', 45)->nullable();

            $table->timestamps();

            // Index để admin lọc nhanh
            $table->index('status');
            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_requests');
    }
};
