<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Services\AbsensiService;
use App\Services\SiswaService;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    protected $siswaService;
    protected $absensiService;

    public function __construct(SiswaService $siswaService, AbsensiService $absensiService)
    {
        $this->siswaService = $siswaService;
        $this->absensiService = $absensiService;
    }

    public function index()
    {
        return view('Ortu.monitoring.index');
    }

    public function search(Request $request)
    {
        // If GET request, redirect to index
        if ($request->isMethod('get')) {
            return redirect()->route('ortu.monitoring.index');
        }

        $validated = $request->validate([
            'nis' => 'required|string|size:5',
        ]);

        $siswa = $this->siswaService->findSiswaByNis($validated['nis']);

        if (!$siswa) {
            return redirect()->route('ortu.monitoring.index')
                ->with('error', 'Siswa dengan NIS tersebut tidak ditemukan');
        }

        // Get attendance history for last 30 days
        $absensis = $this->absensiService->getAbsensiBySiswa($siswa, 30);

        // Calculate statistics
        $statistics = $this->absensiService->getStatistics($absensis);

        return view('Ortu.monitoring.result', [
            'siswa' => $siswa,
            'absensis' => $absensis,
            'totalHadir' => $statistics['total_hadir'],
            'totalAbsensi' => $statistics['total_absensi'],
        ]);
    }
}
