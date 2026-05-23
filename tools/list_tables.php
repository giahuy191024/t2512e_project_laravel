<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::select('SHOW TABLES');
$tables = [];
foreach ($rows as $r) {
    foreach ($r as $v) $tables[] = $v;
}

echo "Found " . count($tables) . " tables:\n";
foreach ($tables as $t) echo "- $t\n";
