<?php
// Script to create missing tables and import minimal data (payment_methods)
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "Starting creation of missing tables...\n";

$created = [];

// feedbacks
if (!Schema::hasTable('feedbacks')) {
    Schema::create('feedbacks', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('booking_id');
        $table->unsignedBigInteger('patient_id');
        $table->tinyInteger('rating');
        $table->text('comment')->nullable();
        $table->tinyInteger('status')->default(1);
        $table->timestamps();
    });
    $created[] = 'feedbacks';
    echo "Created table feedbacks\n";
} else {
    echo "Table feedbacks already exists, skipped.\n";
}

// medical_results
if (!Schema::hasTable('medical_results')) {
    Schema::create('medical_results', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('booking_id');
        $table->unsignedBigInteger('patient_id');
        $table->unsignedBigInteger('doctor_id');
        $table->text('services_performed')->nullable();
        $table->text('symptoms')->nullable();
        $table->text('conclude')->nullable();
        $table->text('prescription')->nullable();
        $table->text('image_urls')->nullable();
        $table->text('doctor_notes')->nullable();
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->timestamps();
    });
    $created[] = 'medical_results';
    echo "Created table medical_results\n";
} else {
    echo "Table medical_results already exists, skipped.\n";
}

// payment_methods
if (!Schema::hasTable('payment_methods')) {
    Schema::create('payment_methods', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('code', 50)->unique();
        $table->string('method_name', 50);
        $table->tinyInteger('is_active')->default(1);
    });
    $created[] = 'payment_methods';
    echo "Created table payment_methods\n";
} else {
    echo "Table payment_methods already exists, skipped.\n";
}

// transactions
if (!Schema::hasTable('transactions')) {
    Schema::create('transactions', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('booking_id');
        $table->unsignedBigInteger('payment_method_id');
        $table->decimal('amount', 15, 2);
        $table->string('currency', 10)->default('VND');
        $table->string('transaction_code', 100)->nullable();
        $table->tinyInteger('transaction_type')->default(0);
        $table->tinyInteger('status')->default(0);
        $table->tinyInteger('refund_status')->default(0);
        $table->timestamp('payment_date')->nullable();
        $table->text('gateway_response')->nullable();
        $table->timestamps();
    });
    $created[] = 'transactions';
    echo "Created table transactions\n";
} else {
    echo "Table transactions already exists, skipped.\n";
}

// Insert sample data into payment_methods if empty
if (Schema::hasTable('payment_methods')) {
    $count = DB::table('payment_methods')->count();
    if ($count === 0) {
        DB::table('payment_methods')->insert([
            ['code' => 'CASH', 'method_name' => 'Tiền mặt', 'is_active' => 1],
            ['code' => 'MOMO', 'method_name' => 'Ví Momo', 'is_active' => 1],
            ['code' => 'VNPAY', 'method_name' => 'VNPay', 'is_active' => 1],
            ['code' => 'BANK', 'method_name' => 'Chuyển khoản ngân hàng', 'is_active' => 1],
        ]);
        echo "Inserted sample rows into payment_methods\n";
    } else {
        echo "payment_methods already has $count rows, skipping inserts.\n";
    }
}

// Summary counts
$tablesToCheck = ['feedbacks','medical_results','payment_methods','transactions'];
foreach ($tablesToCheck as $t) {
    if (Schema::hasTable($t)) {
        $n = DB::table($t)->count();
        echo "Table $t exists, rows: $n\n";
    } else {
        echo "Table $t DOES NOT exist after operation.\n";
    }
}

echo "Done.\n";
