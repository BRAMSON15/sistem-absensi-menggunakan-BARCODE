<?php

namespace App\Services;

use App\Models\Kelas;
use App\Models\Guru;

class KelasService
{
    /**
     * Get all classes for a teacher
     */
    public function getKelasByGuru(Guru $guru)
    {
        return Kelas::where('guru_id', $guru->id)
            ->with(['mataPelajaran', 'siswas'])
            ->latest()
            ->get();
    }

    /**
     * Create a new class
     */
    public function createKelas(array $data, Guru $guru)
    {
        $data['guru_id'] = $guru->id;
        return Kelas::create($data);
    }

    /**
     * Update class data
     */
    public function updateKelas(Kelas $kelas, array $data)
    {
        $kelas->update($data);
        return $kelas->fresh(['mataPelajaran', 'siswas']);
    }

    /**
     * Delete class
     */
    public function deleteKelas(Kelas $kelas)
    {
        return $kelas->delete();
    }

    /**
     * Toggle class active status
     */
    public function toggleActiveStatus(Kelas $kelas)
    {
        $kelas->update(['is_active' => !$kelas->is_active]);
        return $kelas->fresh();
    }

    /**
     * Sync students to class
     */
    public function syncSiswas(Kelas $kelas, array $siswaIds)
    {
        $kelas->siswas()->sync($siswaIds);
        return $kelas->fresh('siswas');
    }

    /**
     * Check if teacher owns the class
     */
    public function isKelasOwnedByGuru(Kelas $kelas, Guru $guru)
    {
        return $kelas->guru_id === $guru->id;
    }

    /**
     * Check if class is active
     */
    public function isKelasActive(Kelas $kelas)
    {
        return $kelas->is_active;
    }

    /**
     * Get class with relationships
     */
    public function getKelasWithRelations(int $id)
    {
        return Kelas::with(['guru', 'mataPelajaran', 'siswas'])->findOrFail($id);
    }
}
