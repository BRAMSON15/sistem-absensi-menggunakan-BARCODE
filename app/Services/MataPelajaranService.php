<?php

namespace App\Services;

use App\Models\MataPelajaran;

class MataPelajaranService
{
    /**
     * Get all subjects
     */
    public function getAllMataPelajarans()
    {
        return MataPelajaran::latest()->get();
    }

    /**
     * Create a new subject
     */
    public function createMataPelajaran(array $data)
    {
        return MataPelajaran::create($data);
    }

    /**
     * Update subject data
     */
    public function updateMataPelajaran(MataPelajaran $mataPelajaran, array $data)
    {
        $mataPelajaran->update($data);
        return $mataPelajaran->fresh();
    }

    /**
     * Delete subject
     */
    public function deleteMataPelajaran(MataPelajaran $mataPelajaran)
    {
        return $mataPelajaran->delete();
    }

    /**
     * Find subject by ID
     */
    public function findMataPelajaranById(int $id)
    {
        return MataPelajaran::findOrFail($id);
    }

    /**
     * Delete all subjects
     */
    public function deleteAll()
    {
        return MataPelajaran::query()->delete();
    }
}
