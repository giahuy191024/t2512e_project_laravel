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
        Schema::table('bookings', function (Blueprint $table) {
            // 0 = chưa đọc, 1 = đã đọc - dùng để hiện thông báo huỷ cho bệnh nhân
            $table->boolean('patient_read')->default(0)->after('cancel_reason');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('patient_read');
        });
    }
};
