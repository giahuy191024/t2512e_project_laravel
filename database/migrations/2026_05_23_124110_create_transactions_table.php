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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();

        $table->foreignId('booking_id')->constrained()->onDelete('cascade');

        $table->foreignId('payment_method_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete();

        $table->decimal('amount', 10, 2);

        $table->string('currency')->default('USD');

        $table->string('transaction_code')->unique();

        $table->tinyInteger('status')->default(0);
        // 0 = pending
        // 1 = success
        // 2 = failed

        $table->timestamp('payment_date')->nullable();

        $table->longText('gateway_response')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
