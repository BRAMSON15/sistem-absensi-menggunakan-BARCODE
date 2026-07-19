<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Services\GuruService;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class GuruController extends Controller
{
    protected $guruService;

    public function __construct(GuruService $guruService)
    {
        $this->guruService = $guruService;
    }

    public function index()
    {
        $gurus = $this->guruService->getAllGurus();
        return view('Admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('Admin.guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        $this->guruService->createGuru($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit(Guru $guru)
    {
        return view('Admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|unique:gurus,nip,' . $guru->id,
            'username' => 'required|string|unique:users,username,' . $guru->user_id,
            'password' => 'nullable|string|min:8',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        $this->guruService->updateGuru($guru, $validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil diupdate');
    }

    public function destroy(Guru $guru)
    {
        $this->guruService->deleteGuru($guru);
        
        return redirect()->route('admin.guru.index')
            ->with('success', 'Guru berhasil dihapus');
    }

    public function destroyAll()
    {
        $this->guruService->deleteAllGurus();
        
        return redirect()->route('admin.guru.index')
            ->with('success', 'Semua data guru berhasil dihapus');
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
            $namaIndex = -1;
            $nipIndex = -1;
            $agamaIndex = -1;
            $alamatIndex = -1;

            foreach ($rows as $row) {
                // Ensure $row is an array and get its values
                $values = array_values($row);

                // Find the header row dynamically
                if (!$isDataRow) {
                    foreach ($values as $index => $val) {
                        $valStr = trim(strtolower((string)$val));
                        if ($valStr === 'nama' || $valStr === 'nama guru') {
                            $namaIndex = $index;
                        }
                        if ($valStr === 'nip') {
                            $nipIndex = $index;
                        }
                        if ($valStr === 'agama') {
                            $agamaIndex = $index;
                        }
                        if ($valStr === 'alamat') {
                            $alamatIndex = $index;
                        }
                    }

                    // If both columns are found, we mark the next rows as data
                    if ($namaIndex !== -1 && $nipIndex !== -1) {
                        $isDataRow = true;
                    }
                    continue; // Skip the row whether it's header or title
                }

                // Parse data row
                $nama = isset($values[$namaIndex]) ? trim((string)$values[$namaIndex]) : '';
                $nip = isset($values[$nipIndex]) ? trim((string)$values[$nipIndex]) : '';

                // Skip if NIP or Nama is empty
                if (empty($nip) || empty($nama)) {
                    continue;
                }

                // Check if NIP already exists
                if ($this->guruService->findGuruByNip($nip)) {
                    continue;
                }

                // Parse additional data rows
                $agama = isset($agamaIndex) && $agamaIndex !== -1 && isset($values[$agamaIndex]) ? trim((string)$values[$agamaIndex]) : null;
                $alamat = isset($alamatIndex) && $alamatIndex !== -1 && isset($values[$alamatIndex]) ? trim((string)$values[$alamatIndex]) : null;

                $this->guruService->createGuru([
                    'nama_guru' => $nama,
                    'nip' => $nip,
                    'username' => $nama, // Default username is Name
                    'password' => $nip, // Default password is NIP
                    'agama' => $agama,
                    'alamat' => $alamat,
                ]);
                $importedCount++;
            }

            return redirect()->route('admin.guru.index')
                ->with('success', $importedCount . ' Data guru berhasil diimport dari Excel');

        } catch (\Exception $e) {
            return redirect()->route('admin.guru.index')
                ->with('error', 'Terjadi kesalahan saat mengimport file: ' . $e->getMessage());
        }
    }
}
