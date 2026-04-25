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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();

            $table->string('department');
            $table->string('service_type')->nullable();

            $table->date('appointment_date');
            $table->string('time_slot');

            $table->string('doctor_name')->nullable();
            $table->string('status')->default('confirmed');

            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
