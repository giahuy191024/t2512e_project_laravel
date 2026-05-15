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
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('id');
            $table->string('full_name')->nullable()->after('user_id');
            $table->string('phone_number', 20)->nullable()->after('full_name');
            $table->string('email_contact')->nullable()->after('phone_number');
            $table->string('address_line')->nullable()->after('email_contact');
            $table->string('ward')->nullable()->after('address_line');
            $table->string('district')->nullable()->after('ward');
            $table->string('city')->nullable()->after('district');
            $table->text('medical_history')->nullable()->after('city');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id','full_name','phone_number','email_contact',
                'address_line','ward','district','city','medical_history'
            ]);
        });
    }
};
