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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã bưu cục (ví dụ: HN_001)
            $table->string('name'); // Tên đại lý/bưu cục

            // Thông tin liên lạc
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('manager_name')->nullable(); // Tên người quản lý

            // Địa chỉ chi tiết
            $table->string('address');
            $table->string('ward')->nullable(); // Phường/Xã
            $table->string('district')->nullable(); // Quận/Huyện
            $table->string('province')->nullable(); // Tỉnh/Thành phố

            // Tọa độ để hiển thị trên bản đồ (nếu cần)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Trạng thái & Loại hình
            $table->enum('type', ['main', 'sub', 'franchise'])->default('sub'); // Bưu cục chính, phụ, nhượng quyền
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động

            $table->timestamps();
            $table->softDeletes(); // Xóa mềm để giữ lịch sử vận đơn
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
