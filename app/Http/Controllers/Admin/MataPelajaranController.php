<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Services\MataPelajaranService;
use Illuminate\Http\Request;

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
            'kode_mapel' => 'required|string|unique:mata_pelajarans,kode_mapel',
        ]);

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
            'kode_mapel' => 'required|string|unique:mata_pelajarans,kode_mapel,' . $mataPelajaran->id,
        ]);

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
}
