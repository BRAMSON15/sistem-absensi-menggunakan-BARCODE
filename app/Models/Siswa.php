<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $fillable = [
        'nis',
        'nama_siswa',
        'foto',
        'tahun_angkatan',
        'kelas',
        'jurusan',
        'barcode',
        'no_wa_ortu',
        'data_tambahan',
    ];

    protected $casts = [
        'data_tambahan' => 'array',
    ];

    public function kelasList(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa');
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
