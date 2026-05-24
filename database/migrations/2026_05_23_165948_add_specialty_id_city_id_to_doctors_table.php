<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('specialty_id')
                ->nullable()
                ->after('specialty')
                ->constrained('specialties')
                ->nullOnDelete();

            $table->foreignId('city_id')
                ->nullable()
                ->after('city')
                ->constrained('cities')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['specialty_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn(['specialty_id', 'city_id']);
        });
    }
};
