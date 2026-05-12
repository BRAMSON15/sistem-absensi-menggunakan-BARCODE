<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Services\GuruService;
use Illuminate\Http\Request;

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
}
