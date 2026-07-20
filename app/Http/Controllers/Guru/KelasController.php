<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Services\KelasService;
use App\Services\SiswaService;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    protected $kelasService;
    protected $siswaService;

    public function __construct(KelasService $kelasService, SiswaService $siswaService)
    {
        $this->kelasService = $kelasService;
        $this->siswaService = $siswaService;
    }

    public function index()
    {
        $guru = auth()->user()->guru;
        $kelasList = $this->kelasService->getKelasByGuru($guru);
        
        return view('Guru.kelas.index', compact('kelasList'));
    }

    public function create()
    {
        $mataPelajarans = MataPelajaran::all();
        $jurusans = \App\Models\Jurusan::all();
        return view('Guru.kelas.create', compact('mataPelajarans', 'jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nama_kelas' => 'required|string|max:255',
            'tingkat_kelas' => 'required|integer|min:1|max:3',
            'jurusan' => 'nullable|string|max:50',
        ]);

        $guru = auth()->user()->guru;
        $this->kelasService->createKelas($validated, $guru);

        return redirect()->route('guru.kelas.index')
            ->with('success', 'Kelas berhasil dibuat');
    }

    public function edit(Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $mataPelajarans = MataPelajaran::all();
        $jurusans = \App\Models\Jurusan::all();
        return view('Guru.kelas.edit', compact('kela', 'mataPelajarans', 'jurusans'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'nama_kelas' => 'required|string|max:255',
            'tingkat_kelas' => 'required|integer|min:1|max:3',
            'jurusan' => 'nullable|string|max:50',
        ]);

        $this->kelasService->updateKelas($kela, $validated);

        return redirect()->route('guru.kelas.index')
            ->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy(Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $this->kelasService->deleteKelas($kela);
        
        return redirect()->route('guru.kelas.index')
            ->with('success', 'Kelas berhasil dihapus');
    }

    public function toggleActive(Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $kela = $this->kelasService->toggleActiveStatus($kela);

        $status = $kela->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('guru.kelas.index')
            ->with('success', "Kelas berhasil {$status}");
    }

    public function manageSiswa(Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $siswas = $this->siswaService->getSiswasByKelas($kela->tingkat_kelas);
        $kelaSiswas = $kela->siswas->pluck('id')->toArray();

        return view('Guru.kelas.manage-siswa', compact('kela', 'siswas', 'kelaSiswas'));
    }

    public function updateSiswa(Request $request, Kelas $kela)
    {
        $guru = auth()->user()->guru;

        if (!$this->kelasService->isKelasOwnedByGuru($kela, $guru)) {
            abort(403);
        }

        $validated = $request->validate([
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:siswas,id',
        ]);

        $this->kelasService->syncSiswas($kela, $validated['siswa_ids'] ?? []);

        return redirect()->route('guru.kelas.index')
            ->with('success', 'Daftar siswa berhasil diupdate');
    }
}
