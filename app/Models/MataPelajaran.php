<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
    ];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }
}
