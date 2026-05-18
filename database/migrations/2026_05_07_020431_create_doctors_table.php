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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id') -> unique();
            $table->string('speciality') -> nullable();
            $table->string('certificate_url') -> nullable();
            $table->integer('experience_years') -> nullable();
            $table->text('bio') -> nullable();
            //home page fiels
            $table->string('image') -> nullable();
            $table->string('region') -> nullable();
            $table->boolean('featured') -> default(false);
            $table->tinyInteger('status') -> default(1);
            $table->unsignedBigInteger('created_by') -> nullable();
            $table->unsignedBigInteger('updated_by') -> nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
