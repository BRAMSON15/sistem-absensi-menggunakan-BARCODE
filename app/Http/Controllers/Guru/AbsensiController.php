<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Services\AbsensiService;
use App\Services\KelasService;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    protected $absensiService;
    protected $kelasService;

    public function __construct(AbsensiService $absensiService, KelasService $kelasService)
    {
        $this->absensiService = $absensiService;
        $this->kelasService = $kelasService;
    }

    public function scan(Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        if (!$this->kelasService->isKelasActive($kela)) {
            return redirect()->route('guru.kelas.index')
                ->with('error', 'Kelas belum diaktifkan untuk absensi');
        }

        return view('Guru.absensi.scan', compact('kela'));
    }

    public function processScan(Request $request, Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke kelas ini'
            ], 403);
        }

        if (!$this->kelasService->isKelasActive($kela)) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak aktif. Silakan aktifkan kelas terlebih dahulu.'
            ], 400);
        }

        $validated = $request->validate([
            'barcode' => 'required|string',
        ]);

        // Process scan using service
        $result = $this->absensiService->processScan($kela, $validated['barcode']);

        // Determine HTTP status code based on result
        $statusCode = $result['success'] ? 200 : 400;
        if (isset($result['code']) && $result['code'] === 'STUDENT_NOT_FOUND') {
            $statusCode = 404;
        }

        return response()->json($result, $statusCode);
    }

    public function riwayat(Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $absensis = $this->absensiService->getAbsensiByKelas($kela);

        return view('Guru.absensi.riwayat', compact('kela', 'absensis'));
    }

    public function destroy(Kelas $kela, $absensi)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        // Find absensi by ID
        $absensiRecord = \App\Models\Absensi::findOrFail($absensi);

        // Verify absensi belongs to this kelas
        if ($absensiRecord->kelas_id !== $kela->id) {
            abort(403);
        }

        $absensiRecord->delete();

        return redirect()->route('guru.absensi.riwayat', $kela)
            ->with('success', 'Data absensi berhasil dihapus');
    }
}
