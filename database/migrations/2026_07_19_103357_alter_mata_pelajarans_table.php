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
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->dropColumn('kode_mapel');
            $table->string('nama_guru')->nullable()->after('nama_mapel');
            $table->json('data_tambahan')->nullable()->after('nama_guru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_pelajarans', function (Blueprint $table) {
            $table->string('kode_mapel')->unique()->nullable();
            $table->dropColumn(['nama_guru', 'data_tambahan']);
        });
    }
};
