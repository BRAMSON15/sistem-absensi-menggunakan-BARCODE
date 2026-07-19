<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$siswas = App\Models\Siswa::all();
$count = 0;
foreach ($siswas as $siswa) {
    if (is_array($siswa->data_tambahan) && array_key_exists('No', $siswa->data_tambahan)) {
        $dt = $siswa->data_tambahan;
        unset($dt['No']);
        // Save back
        $siswa->data_tambahan = empty($dt) ? null : $dt;
        $siswa->save();
        $count++;
    }
}
echo "Cleaned $count records.\n";
