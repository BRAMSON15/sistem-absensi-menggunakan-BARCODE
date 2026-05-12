<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Services\KelasService;
use App\Services\LaporanService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    protected $laporanService;
    protected $kelasService;

    public function __construct(LaporanService $laporanService, KelasService $kelasService)
    {
        $this->laporanService = $laporanService;
        $this->kelasService = $kelasService;
    }

    public function index(Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        return view('Guru.laporan.index', compact('kela'));
    }

    public function generate(Request $request, Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $report = $this->laporanService->generateReport(
            $kela,
            $validated['tanggal_mulai'],
            $validated['tanggal_akhir']
        );

        return view('Guru.laporan.result', [
            'kela' => $kela,
            'absensis' => $report['absensis'],
            'totalHadir' => $report['statistics']['total_hadir'],
            'totalAbsensi' => $report['statistics']['total_absensi'],
            'laporanPerSiswa' => $report['report_per_siswa'],
            'validated' => $validated,
        ]);
    }

    public function exportCsv(Request $request, Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $csvStream = $this->laporanService->streamCsv(
            $kela,
            $validated['tanggal_mulai'],
            $validated['tanggal_akhir']
        );

        return response()->stream($csvStream['callback'], 200, $csvStream['headers']);
    }

    public function exportExcel(Request $request, Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $html = $this->laporanService->generateExcelHtml(
            $kela,
            $validated['tanggal_mulai'],
            $validated['tanggal_akhir']
        );

        $filename = 'laporan_absensi_' . $kela->id . '_' . date('YmdHis') . '.xls';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportPdf(Request $request, Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $html = $this->laporanService->generateExcelHtml(
            $kela,
            $validated['tanggal_mulai'],
            $validated['tanggal_akhir']
        );

        // For PDF, we'll use the same HTML but with PDF-friendly styling
        $html = str_replace('<style>', '<style>@page { size: A4 landscape; margin: 20mm; }', $html);

        $filename = 'laporan_absensi_' . $kela->id . '_' . date('YmdHis') . '.pdf';

        // Using browser's print to PDF functionality
        return response()->view('Guru.laporan.pdf', [
            'html' => $html,
            'filename' => $filename,
            'kela' => $kela,
            'validated' => $validated
        ]);
    }
}
