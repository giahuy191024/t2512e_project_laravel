<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('role')->default(0)->comment('0=patient, 1=doctor, 2=admin');
            $table->tinyInteger('gender')->nullable()->comment('0=female, 1=male, 2=other');
            $table->date('date_of_birth')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->timestamps();
            // FK self-reference sẽ thêm ở migration cuối cùng
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
