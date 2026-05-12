<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'nama_kelas',
        'tingkat_kelas',
        'jurusan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function siswas(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa');
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
