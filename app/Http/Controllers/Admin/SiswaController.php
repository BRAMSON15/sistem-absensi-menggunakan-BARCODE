<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Services\SiswaService;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class SiswaController extends Controller
{
    protected $siswaService;

    public function __construct(SiswaService $siswaService)
    {
        $this->siswaService = $siswaService;
    }

    public function index()
    {
        $siswas = $this->siswaService->getAllSiswas();
        return view('Admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('Admin.siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|unique:siswas,nis|size:5',
            'tahun_angkatan' => 'required|integer|min:2000|max:2099',
            'kelas' => 'required|integer|min:1|max:3',
            'jurusan' => 'required|string|in:TKJ,RPL,MM,TBSM,TKRO,TKR,TEI,TAV,TITL,TM,TP,AKL,OTKP,BDP',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $this->siswaService->createSiswa($validated);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit(Siswa $siswa)
    {
        return view('Admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|string|size:5|unique:siswas,nis,' . $siswa->id,
            'tahun_angkatan' => 'required|integer|min:2000|max:2099',
            'kelas' => 'required|integer|min:1|max:3',
            'jurusan' => 'required|string|in:TKJ,RPL,MM,TBSM,TKRO,TKR,TEI,TAV,TITL,TM,TP,AKL,OTKP,BDP',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Process dynamic extra columns
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

        $this->siswaService->updateSiswa($siswa, $validated);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil diupdate');
    }

    public function destroy(Siswa $siswa)
    {
        $this->siswaService->deleteSiswa($siswa);
        
        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus');
    }

    public function generateBarcode(Siswa $siswa)
    {
        return view('Admin.siswa.barcode', compact('siswa'));
    }

    public function destroyAll()
    {
        $this->siswaService->deleteAllSiswas();
        
        return redirect()->route('admin.siswa.index')
            ->with('success', 'Semua data siswa berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        $file = $request->file('file');
        
        try {
            $extension = $file->getClientOriginalExtension();
            $rows = SimpleExcelReader::create($file->getRealPath(), $extension)
                ->noHeaderRow()
                ->getRows();
            
            $importedCount = 0;
            $isDataRow = false;
            $headerColumns = [];
            $noIndex = -1;
            $namaIndex = -1;
            $nisIndex = -1;
            $tahunAngkatanIndex = -1;
            $kelasIndex = -1;
            $jurusanIndex = -1;

            foreach ($rows as $row) {
                // Ensure $row is an array and get its values
                $values = array_values($row);

                // Find the header row dynamically
                if (!$isDataRow) {
                    foreach ($values as $index => $val) {
                        $valStr = trim(strtolower((string)$val));
                        if (empty($valStr)) continue;
                        $headerColumns[$index] = trim((string)$val);
                        
                        if ($valStr === 'nama' || $valStr === 'nama siswa') {
                            $namaIndex = $index;
                        } else if ($valStr === 'nis' || $valStr === 'nisn') {
                            $nisIndex = $index;
                        } else if (str_contains($valStr, 'tahun')) {
                            $tahunAngkatanIndex = $index;
                        } else if (str_contains($valStr, 'kelas')) {
                            $kelasIndex = $index;
                        } else if (str_contains($valStr, 'jurusan')) {
                            $jurusanIndex = $index;
                        } else if ($valStr === 'no' || $valStr === 'nomor') {
                            $noIndex = $index;
                        }
                    }

                    // If basic columns are found, we mark the next rows as data
                    if ($namaIndex !== -1 && $nisIndex !== -1) {
                        $isDataRow = true;
                    }
                    continue; // Skip the row whether it's header or title
                }

                // Parse data row
                $nama = isset($values[$namaIndex]) ? trim((string)$values[$namaIndex]) : '';
                $nis = isset($values[$nisIndex]) ? trim((string)$values[$nisIndex]) : '';
                
                // Skip if NIS or Nama is empty
                if (empty($nis) || empty($nama)) {
                    continue;
                }

                // Check if NIS already exists
                if ($this->siswaService->findSiswaByNis($nis)) {
                    continue;
                }
                
                // Default values if not specified
                $tahunAngkatan = (isset($tahunAngkatanIndex) && $tahunAngkatanIndex !== -1 && !empty(trim((string)$values[$tahunAngkatanIndex]))) ? trim((string)$values[$tahunAngkatanIndex]) : date('Y');
                $kelas = (isset($kelasIndex) && $kelasIndex !== -1 && !empty(trim((string)$values[$kelasIndex]))) ? trim((string)$values[$kelasIndex]) : '1';
                // Try to infer numeric class
                if (!is_numeric($kelas)) {
                    $kelas = str_contains(strtolower($kelas), 'xii') ? '3' : (str_contains(strtolower($kelas), 'xi') ? '2' : '1');
                }
                $jurusan = (isset($jurusanIndex) && $jurusanIndex !== -1 && !empty(trim((string)$values[$jurusanIndex]))) ? trim((string)$values[$jurusanIndex]) : 'TKJ'; // Default to TKJ if not found
                $jurusan = strtoupper($jurusan);

                // Collect extra columns
                $dataTambahan = [];
                foreach ($values as $index => $val) {
                    if (isset($headerColumns[$index])) {
                        if (!in_array($index, [$namaIndex, $nisIndex, $tahunAngkatanIndex, $kelasIndex, $jurusanIndex, $noIndex], true)) {
                            // Only add if there is a value
                            if (!empty(trim((string)$val))) {
                                $dataTambahan[$headerColumns[$index]] = trim((string)$val);
                            }
                        }
                    }
                }

                $this->siswaService->createSiswa([
                    'nama_siswa' => $nama,
                    'nis' => $nis,
                    'tahun_angkatan' => $tahunAngkatan,
                    'kelas' => $kelas,
                    'jurusan' => $jurusan,
                    'data_tambahan' => $dataTambahan,
                ]);
                $importedCount++;
            }

            return redirect()->route('admin.siswa.index')
                ->with('success', $importedCount . ' Data siswa berhasil diimport dari Excel');

        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Terjadi kesalahan saat mengimport file: ' . $e->getMessage());
        }
    }
}
