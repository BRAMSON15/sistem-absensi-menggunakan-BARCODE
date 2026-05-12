<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Services\SiswaService;
use Illuminate\Http\Request;

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
}
