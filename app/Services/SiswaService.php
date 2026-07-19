<?php

namespace App\Services;

use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;

class SiswaService
{
    /**
     * Get all students
     */
    public function getAllSiswas()
    {
        return Siswa::latest()->get();
    }

    /**
     * Create a new student
     */
    public function createSiswa(array $data)
    {
        // Handle photo upload
        if (isset($data['foto']) && $data['foto']) {
            $data['foto'] = $data['foto']->store('siswa-foto', 'public');
        }

        // Set barcode same as NIS
        $data['barcode'] = $data['nis'];

        return Siswa::create($data);
    }

    /**
     * Update student data
     */
    public function updateSiswa(Siswa $siswa, array $data)
    {
        // Handle photo upload
        if (isset($data['foto']) && $data['foto']) {
            // Delete old photo if exists
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $data['foto']->store('siswa-foto', 'public');
        }

        // Update barcode if NIS changed
        if (isset($data['nis'])) {
            $data['barcode'] = $data['nis'];
        }

        $siswa->update($data);

        return $siswa->fresh();
    }

    /**
     * Delete student
     */
    public function deleteSiswa(Siswa $siswa)
    {
        // Delete photo if exists
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        return $siswa->delete();
    }

    /**
     * Delete all students
     */
    public function deleteAllSiswas()
    {
        // Delete all photos first
        $fotos = Siswa::whereNotNull('foto')->pluck('foto');
        if ($fotos->count() > 0) {
            Storage::disk('public')->delete($fotos->toArray());
        }
        
        return Siswa::query()->delete();
    }

    /**
     * Find student by ID
     */
    public function findSiswaById(int $id)
    {
        return Siswa::findOrFail($id);
    }

    /**
     * Find student by NIS
     */
    public function findSiswaByNis(string $nis)
    {
        return Siswa::where('nis', $nis)->first();
    }

    /**
     * Find student by barcode or NIS
     */
    public function findSiswaByBarcodeOrNis(string $code)
    {
        return Siswa::where('barcode', $code)
                    ->orWhere('nis', $code)
                    ->first();
    }

    /**
     * Get students by grade level
     */
    public function getSiswasByKelas(int $kelas)
    {
        return Siswa::where('kelas', $kelas)->get();
    }

    /**
     * Get students by year
     */
    public function getSiswasByTahunAngkatan(int $tahun)
    {
        return Siswa::where('tahun_angkatan', $tahun)->get();
    }
}
