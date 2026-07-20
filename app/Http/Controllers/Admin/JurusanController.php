<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Services\JurusanService;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class JurusanController extends Controller
{
    protected $jurusanService;

    public function __construct(JurusanService $jurusanService)
    {
        $this->jurusanService = $jurusanService;
    }

    public function index()
    {
        $jurusans = $this->jurusanService->getAllJurusans();
        return view('Admin.jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('Admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
        ]);

        $dataTambahan = [];
        foreach ($request->except(['_token', 'nama_jurusan']) as $key => $value) {
            if (str_starts_with($key, 'dynamic_')) {
                $realKey = str_replace('dynamic_', '', $key);
                $realKey = str_replace('_', ' ', $realKey);
                if (!empty(trim((string)$value))) {
                    $dataTambahan[$realKey] = $value;
                }
            }
        }

        $validated['data_tambahan'] = $dataTambahan;

        $this->jurusanService->createJurusan($validated);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('Admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'nama_jurusan' => 'required|string|max:255',
        ]);

        $dataTambahan = [];
        foreach ($request->except(['_token', '_method', 'nama_jurusan']) as $key => $value) {
            if (str_starts_with($key, 'dynamic_')) {
                $realKey = str_replace('dynamic_', '', $key);
                $realKey = str_replace('_', ' ', $realKey);
                if (!empty(trim((string)$value))) {
                    $dataTambahan[$realKey] = $value;
                }
            }
        }

        $validated['data_tambahan'] = $dataTambahan;

        $this->jurusanService->updateJurusan($jurusan, $validated);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil diupdate');
    }

    public function destroy(Jurusan $jurusan)
    {
        $this->jurusanService->deleteJurusan($jurusan);
        
        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus');
    }

    public function destroyAll()
    {
        $this->jurusanService->deleteAllJurusans();
        
        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Semua data jurusan berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $rows = SimpleExcelReader::create($file->getRealPath(), $extension)
                ->noHeaderRow()
                ->getRows();
            
            $importedCount = 0;
            $isDataRow = false;
            $headerColumns = [];
            $noIndex = -1;
            $namaJurusanIndex = -1;

            foreach ($rows as $row) {
                $values = array_values($row);

                if (!$isDataRow) {
                    $nonEmptyCount = 0;
                    foreach ($values as $val) {
                        if (!empty(trim((string)$val))) $nonEmptyCount++;
                    }

                    // Assume it's a header row if it has at least 1 non-empty column (since Jurusan only requires 1 column)
                    // Better yet, just the first row with any text.
                    if ($nonEmptyCount > 0) {
                        foreach ($values as $index => $val) {
                            $valStr = trim(strtolower((string)$val));
                            if (empty($valStr)) continue;
                            $headerColumns[$index] = trim((string)$val);
                            
                            if (str_contains($valStr, 'no') || str_contains($valStr, 'nomor')) {
                                $noIndex = $index;
                            } else if (str_contains($valStr, 'nama') || str_contains($valStr, 'jurusan') || str_contains($valStr, 'program') || str_contains($valStr, 'kompetensi') || str_contains($valStr, 'keahlian')) {
                                $namaJurusanIndex = $index;
                            }
                        }

                        // Ultimate Fallback: If no Nama Jurusan column found, pick the first column that isn't 'No'
                        if ($namaJurusanIndex === -1) {
                            foreach ($headerColumns as $index => $header) {
                                if ($index !== $noIndex) {
                                    $namaJurusanIndex = $index;
                                    break;
                                }
                            }
                        }

                        $isDataRow = true;
                    }
                    continue;
                }

                $namaJurusan = (isset($namaJurusanIndex) && $namaJurusanIndex !== -1 && !empty(trim((string)$values[$namaJurusanIndex]))) ? trim((string)$values[$namaJurusanIndex]) : null;
                if (!$namaJurusan) continue;

                $dataTambahan = [];
                foreach ($values as $index => $val) {
                    if (isset($headerColumns[$index])) {
                        if (!in_array($index, [$namaJurusanIndex, $noIndex], true)) {
                            if (!empty(trim((string)$val))) {
                                $dataTambahan[$headerColumns[$index]] = trim((string)$val);
                            }
                        }
                    }
                }

                $this->jurusanService->createJurusan([
                    'nama_jurusan' => $namaJurusan,
                    'data_tambahan' => $dataTambahan,
                ]);
                
                $importedCount++;
            }

            return redirect()->route('admin.jurusan.index')
                ->with('success', "$importedCount data jurusan berhasil diimport dari Excel");

        } catch (\Exception $e) {
            return redirect()->route('admin.jurusan.index')
                ->with('error', 'Terjadi kesalahan saat import data: ' . $e->getMessage());
        }
    }
}
