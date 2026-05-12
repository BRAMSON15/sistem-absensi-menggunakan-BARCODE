<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained()->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained()->onDelete('cascade');
            $table->string('nama_kelas'); // Contoh: "Matematika - Kelas 12 IPA 1"
            $table->integer('tingkat_kelas'); // 1, 2, atau 3
            $table->string('jurusan')->nullable(); // IPA, IPS, dll
            $table->boolean('is_active')->default(false); // Status aktif untuk scan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
