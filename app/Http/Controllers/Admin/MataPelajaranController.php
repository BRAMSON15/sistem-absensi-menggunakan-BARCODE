<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Services\MataPelajaranService;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MataPelajaranController extends Controller
{
    protected $mataPelajaranService;

    public function __construct(MataPelajaranService $mataPelajaranService)
    {
        $this->mataPelajaranService = $mataPelajaranService;
    }

    public function index()
    {
        $mataPelajarans = $this->mataPelajaranService->getAllMataPelajarans();
        return view('Admin.mata-pelajaran.index', compact('mataPelajarans'));
    }

    public function create()
    {
        return view('Admin.mata-pelajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'nama_guru' => 'nullable|string|max:255',
        ]);

        $extraKeys = $request->input('extra_keys', []);
        $extraValues = $request->input('extra_values', []);
        $dataTambahan = [];
        
        foreach ($extraKeys as $index => $key) {
            $key = trim((string)$key);
            if (!empty($key)) {
                $dataTambahan[$key] = isset($extraValues[$index]) ? trim((string)$extraValues[$index]) : '';
            }
        }
        
        $validated['data_tambahan'] = empty($dataTambahan) ? null : $dataTambahan;

        $this->mataPelajaranService->createMataPelajaran($validated);

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('Admin.mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $validated = $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'nama_guru' => 'nullable|string|max:255',
        ]);

        $extraKeys = $request->input('extra_keys', []);
        $extraValues = $request->input('extra_values', []);
        $dataTambahan = [];
        
        foreach ($extraKeys as $index => $key) {
            $key = trim((string)$key);
            if (!empty($key)) {
                $dataTambahan[$key] = isset($extraValues[$index]) ? trim((string)$extraValues[$index]) : '';
            }
        }
        
        $validated['data_tambahan'] = empty($dataTambahan) ? null : $dataTambahan;

        $this->mataPelajaranService->updateMataPelajaran($mataPelajaran, $validated);

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil diupdate');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $this->mataPelajaranService->deleteMataPelajaran($mataPelajaran);
        
        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil dihapus');
    }

    public function destroyAll()
    {
        $this->mataPelajaranService->deleteAll();
        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', 'Semua data mata pelajaran berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $rows = SimpleExcelReader::create($file->getRealPath(), $extension)->getRows();
            
            $importedCount = 0;
            $isDataRow = false;
            $headerColumns = [];
            $noIndex = -1;
            $namaMapelIndex = -1;
            $namaGuruIndex = -1;

            foreach ($rows as $row) {
                $values = array_values($row);

                if (!$isDataRow) {
                    foreach ($values as $index => $val) {
                        $valStr = trim(strtolower((string)$val));
                        if (empty($valStr)) continue;
                        $headerColumns[$index] = trim((string)$val);
                        
                        if ($valStr === 'nama mapel' || $valStr === 'mata pelajaran' || $valStr === 'mapel') {
                            $namaMapelIndex = $index;
                        } else if ($valStr === 'nama guru' || $valStr === 'guru') {
                            $namaGuruIndex = $index;
                        } else if ($valStr === 'no' || $valStr === 'nomor') {
                            $noIndex = $index;
                        }
                    }

                    if ($namaMapelIndex !== -1) {
                        $isDataRow = true;
                    }
                    continue;
                }

                $namaMapel = (isset($namaMapelIndex) && $namaMapelIndex !== -1 && !empty(trim((string)$values[$namaMapelIndex]))) ? trim((string)$values[$namaMapelIndex]) : null;
                if (!$namaMapel) continue;

                $namaGuru = (isset($namaGuruIndex) && $namaGuruIndex !== -1 && !empty(trim((string)$values[$namaGuruIndex]))) ? trim((string)$values[$namaGuruIndex]) : null;

                $dataTambahan = [];
                foreach ($values as $index => $val) {
                    if (isset($headerColumns[$index])) {
                        if (!in_array($index, [$namaMapelIndex, $namaGuruIndex, $noIndex], true)) {
                            if (!empty(trim((string)$val))) {
                                $dataTambahan[$headerColumns[$index]] = trim((string)$val);
                            }
                        }
                    }
                }

                $this->mataPelajaranService->createMataPelajaran([
                    'nama_mapel' => $namaMapel,
                    'nama_guru' => $namaGuru,
                    'data_tambahan' => $dataTambahan,
                ]);
                
                $importedCount++;
            }

            return redirect()->route('admin.mata-pelajaran.index')
                ->with('success', "$importedCount data mata pelajaran berhasil diimport dari Excel");

        } catch (\Exception $e) {
            return redirect()->route('admin.mata-pelajaran.index')
                ->with('error', 'Terjadi kesalahan saat import data: ' . $e->getMessage());
        }
    }
}
