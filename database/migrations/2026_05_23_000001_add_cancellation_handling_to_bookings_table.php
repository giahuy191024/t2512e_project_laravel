<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('admin_handled')->default(0)->after('cancel_reason');
            $table->text('handled_note')->nullable()->after('admin_handled');
            $table->foreignId('transferred_to_id')->nullable()->after('handled_note')
                  ->constrained('bookings')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['transferred_to_id']);
            $table->dropColumn(['admin_handled', 'handled_note', 'transferred_to_id']);
        });
    }
};
