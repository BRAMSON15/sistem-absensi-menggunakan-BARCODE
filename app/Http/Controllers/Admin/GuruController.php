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
            $usernameIndex = -1;
            $agamaIndex = -1;
            $alamatIndex = -1;

            foreach ($rows as $row) {
                // Ensure $row is an array and get its values
                $values = array_values($row);

                // Find the header row dynamically
                if (!$isDataRow) {
                    $nonEmptyCount = 0;
                    foreach ($values as $val) {
                        if (!empty(trim((string)$val))) $nonEmptyCount++;
                    }

                    if ($nonEmptyCount > 1) { // Wait for at least 2 columns
                        $headerColumns = [];
                        foreach ($values as $index => $val) {
                            $valStr = trim(strtolower((string)$val));
                            if (empty($valStr)) continue;
                            $headerColumns[$index] = trim((string)$val);
                            
                            if (str_contains($valStr, 'nama') || str_contains($valStr, 'guru')) {
                                if ($namaIndex === -1) $namaIndex = $index;
                            } else if (str_contains($valStr, 'nip') || str_contains($valStr, 'pegawai') || str_contains($valStr, 'nik')) {
                                if ($nipIndex === -1) $nipIndex = $index;
                            } else if (str_contains($valStr, 'user')) {
                                $usernameIndex = $index;
                            } else if (str_contains($valStr, 'agama')) {
                                $agamaIndex = $index;
                            } else if (str_contains($valStr, 'alamat')) {
                                $alamatIndex = $index;
                            }
                        }

                        // Ultimate Fallback: if we didn't find Nama or NIP, guess them!
                        // Guess Nama is the first text column that isn't NO.
                        if ($namaIndex === -1) {
                            foreach ($headerColumns as $index => $header) {
                                if (!str_contains(strtolower($header), 'no') && !str_contains(strtolower($header), 'nomor')) {
                                    $namaIndex = $index;
                                    break;
                                }
                            }
                        }
                        
                        // Guess NIP is the next column after Nama
                        if ($nipIndex === -1) {
                            foreach ($headerColumns as $index => $header) {
                                if ($index !== $namaIndex && !str_contains(strtolower($header), 'no') && !str_contains(strtolower($header), 'nomor')) {
                                    $nipIndex = $index;
                                    break;
                                }
                            }
                        }

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
                $username = isset($usernameIndex) && $usernameIndex !== -1 && isset($values[$usernameIndex]) && !empty(trim((string)$values[$usernameIndex])) 
                    ? trim((string)$values[$usernameIndex]) 
                    : $nip; // Fallback to NIP if username is not provided

                // Check if username already exists
                if (\App\Models\User::where('username', $username)->exists()) {
                    continue;
                }

                $this->guruService->createGuru([
                    'nama_guru' => $nama,
                    'nip' => $nip,
                    'username' => $username,
                    'password' => $nip, // Password is NIP
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
