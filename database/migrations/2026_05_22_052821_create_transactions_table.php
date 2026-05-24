<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('VND');
            $table->string('transaction_code', 100)->unique()->nullable();
            // Lưu ý: schema gốc ghi "transaction_tupe" (typo). Đã sửa thành "transaction_type"
            $table->tinyInteger('transaction_type')->default(0)
                ->comment('0=payment, 1=refund, 2=deposit');
            $table->tinyInteger('status')->default(0)
                ->comment('0=pending, 1=success, 2=failed, 3=cancelled');
            $table->tinyInteger('refund_status')->default(0)
                ->comment('0=none, 1=pending_refund, 2=refunded, 3=refund_failed');
            $table->timestamp('payment_date')->nullable();
            $table->text('gateway_response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
