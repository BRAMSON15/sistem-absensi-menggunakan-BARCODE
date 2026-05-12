<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;

class AbsensiService
{
    protected $siswaService;

    public function __construct(SiswaService $siswaService)
    {
        $this->siswaService = $siswaService;
    }

    /**
     * Process attendance scan
     */
    public function processScan(Kelas $kelas, string $barcodeOrNis)
    {
        // Find student by barcode or NIS
        $siswa = $this->siswaService->findSiswaByBarcodeOrNis($barcodeOrNis);

        if (!$siswa) {
            return [
                'success' => false,
                'message' => 'Siswa dengan NIS/Barcode "' . $barcodeOrNis . '" tidak ditemukan dalam sistem',
                'code' => 'STUDENT_NOT_FOUND'
            ];
        }

        // Check if student is enrolled in this class
        if (!$kelas->siswas->contains($siswa->id)) {
            return [
                'success' => false,
                'message' => 'Siswa ' . $siswa->nama_siswa . ' tidak terdaftar di kelas ini. Silakan tambahkan siswa ke kelas terlebih dahulu.',
                'code' => 'STUDENT_NOT_ENROLLED'
            ];
        }

        // Check if already attended today
        $existingAbsensi = $this->checkTodayAttendance($kelas, $siswa);
        if ($existingAbsensi) {
            return [
                'success' => false,
                'message' => 'Siswa ' . $siswa->nama_siswa . ' sudah melakukan absensi hari ini',
                'code' => 'ALREADY_ATTENDED',
                'data' => [
                    'nama' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'waktu' => $existingAbsensi->waktu_scan,
                    'status' => $existingAbsensi->status,
                ]
            ];
        }

        // Create attendance record
        $absensi = $this->createAbsensi($kelas, $siswa);

        return [
            'success' => true,
            'message' => 'Absensi berhasil dicatat untuk ' . $siswa->nama_siswa,
            'data' => [
                'nama' => $siswa->nama_siswa,
                'nis' => $siswa->nis,
                'waktu' => $absensi->waktu_scan,
                'status' => $absensi->status,
            ]
        ];
    }

    /**
     * Check if student already attended today
     */
    public function checkTodayAttendance(Kelas $kelas, Siswa $siswa)
    {
        return Absensi::where('kelas_id', $kelas->id)
            ->where('siswa_id', $siswa->id)
            ->where('tanggal', Carbon::today())
            ->first();
    }

    /**
     * Create attendance record
     */
    public function createAbsensi(Kelas $kelas, Siswa $siswa)
    {
        $now = Carbon::now();
        
        // All attendance marked as "hadir"
        $status = 'hadir';

        return Absensi::create([
            'kelas_id' => $kelas->id,
            'siswa_id' => $siswa->id,
            'tanggal' => Carbon::today(),
            'waktu_scan' => $now->format('H:i:s'),
            'status' => $status,
        ]);
    }

    /**
     * Get attendance history for a class
     */
    public function getAbsensiByKelas(Kelas $kelas, int $perPage = 50)
    {
        return Absensi::where('kelas_id', $kelas->id)
            ->with('siswa')
            ->latest('tanggal')
            ->latest('waktu_scan')
            ->paginate($perPage);
    }

    /**
     * Get attendance by date range
     */
    public function getAbsensiByDateRange(Kelas $kelas, string $startDate, string $endDate)
    {
        return Absensi::where('kelas_id', $kelas->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->with('siswa')
            ->orderBy('tanggal')
            ->orderBy('waktu_scan')
            ->get();
    }

    /**
     * Get attendance statistics
     */
    public function getStatistics($absensis)
    {
        return [
            'total_hadir' => $absensis->where('status', 'hadir')->count(),
            'total_absensi' => $absensis->count(),
        ];
    }

    /**
     * Get attendance report per student
     */
    public function getReportPerSiswa(Kelas $kelas, $absensis)
    {
        return $kelas->siswas->map(function ($siswa) use ($absensis) {
            $absensiSiswa = $absensis->where('siswa_id', $siswa->id);
            return [
                'siswa' => $siswa,
                'total_hadir' => $absensiSiswa->where('status', 'hadir')->count(),
                'total_absensi' => $absensiSiswa->count(),
            ];
        });
    }

    /**
     * Get student attendance history
     */
    public function getAbsensiBySiswa(Siswa $siswa, int $days = 30)
    {
        return Absensi::where('siswa_id', $siswa->id)
            ->with(['kelas.mataPelajaran'])
            ->whereBetween('tanggal', [now()->subDays($days), now()])
            ->latest('tanggal')
            ->latest('waktu_scan')
            ->get();
    }
}
