<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique(); // Format: 01223
            $table->string('nama_siswa');
            $table->string('foto')->nullable();
            $table->integer('tahun_angkatan');
            $table->integer('kelas'); // 1, 2, atau 3
            $table->string('barcode')->unique(); // Barcode untuk scan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
